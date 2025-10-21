#!/bin/bash
set -e

cd /var/www

echo "⚙️  Environment: $APP_ENV"

echo " Current User: $(whoami)"

# 🧹 Ensure vendor is handled inside Docker, not host
# if [ -d "/var/www/vendor" ] && [ ! -L "/var/www/vendor" ]; then
#    echo "🧹 Removing host vendor/ directory to use container volume..."
#    rm -rf /var/www/vendor
# fi

# Recreate vendor directory if missing
# mkdir -p /var/www/vendor

echo "COPYING .env ..."
case "$APP_ENV" in
  production)
    ENV_FILE="/var/www/.env.production.example"
    ;;
  development)
    ENV_FILE="/var/www/.env.development.example"
    ;;
  stage)
    ENV_FILE="/var/www/.env.stage.example"
    ;;
  local)
    ENV_FILE="/var/www/.env.local.example"
    ;;
  *)
    echo "⚠️ Unknown APP_ENV: $APP_ENV, defaulting to development"
    ENV_FILE="/var/www/.env.example"
    ;;
esac

if [ -f "$ENV_FILE" ]; then
    echo "📝 Using $ENV_FILE → .env"
    cp -f "$ENV_FILE" /var/www/.env
else
    echo "⚠️ $ENV_FILE not found!"
fi

MAX_TRIES=3
NUM_TRIES=0
DB_HOST=$(grep DB_HOST /var/www/.env | cut -d '=' -f2)
DB_PORT=$(grep DB_PORT /var/www/.env | cut -d '=' -f2)

echo "⏳ Waiting for database ($DB_HOST:$DB_PORT) to be ready..."
until nc -z "$DB_HOST" "$DB_PORT"; do
    NUM_TRIES=$((NUM_TRIES+1))
    if [ "$NUM_TRIES" -ge "$MAX_TRIES" ]; then
        echo "❌ Could not connect to database after $MAX_TRIES attempts, exiting..."
        exit 1
    fi
    echo "   ⏳ DB not ready attempt $NUM_TRIES/$MAX_TRIES..., retrying in 3s..."
    sleep 3
done
echo "✅ Database is ready!"

if [ "$APP_ENV" != "local" ] && [ "$APP_ENV" != "development" ]; then
    echo "🔧 Setting permissions..."
    chown -R jdecs:www-data /var/www/storage /var/www/bootstrap/cache
    chmod -R ug+rwx /var/www/storage /var/www/bootstrap/cache
    echo "📦 Installing Composer dependencies (prod)..."
    composer install --no-dev --optimize-autoloader
else
    echo "⚠️ Skipping chown for dev/local environments"
    echo "📦 Installing Composer dependencies (dev)..."
    composer install --prefer-source --no-interaction
fi

echo "🛠️  Setting up Laravel..."
php artisan key:generate --force
php artisan jwt:secret --force
php artisan config:clear
php artisan config:cache
# php artisan route:cache
php artisan route:clear
php artisan cache:clear
# php artisan view:cache
php artisan view:clear

echo "📂 Running migrations..."
php artisan migrate --force

echo "🌱 Checking if database seeding is needed..."

# Check if users table already has records
if php artisan tinker --execute="echo \App\Models\User::count();" | grep -q '^[1-9][0-9]*$'; then
    echo "✅ Users already exist — skipping seeding."
else
    echo "🌱 No users found — running UserSeeder..."
    php artisan db:seed --class=UserSeeder --force
fi


echo "✅ [jdecs-entrypoint] Init complete, starting Supervisor..."
exec /usr/bin/supervisord -c /etc/supervisord.conf
