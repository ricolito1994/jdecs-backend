FROM php:8.3-fpm-alpine

# Install deps
RUN apk add --no-cache bash curl git zip unzip supervisor shadow \
    libzip-dev icu-dev libpng-dev libjpeg-turbo-dev libwebp-dev oniguruma-dev \
    linux-headers autoconf make g++ openssl

# PHP extensions
RUN docker-php-ext-configure gd --with-jpeg --with-webp \
    && docker-php-ext-install pdo_mysql zip intl gd \
    && pecl install redis \
    && docker-php-ext-enable redis opcache

# Copy php.ini
COPY docker/php.prod.ini /usr/local/etc/php/php.ini

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# User = jdecs
RUN useradd -G www-data,root -u 1000 -d /home/jdecs jdecs \
    && mkdir -p /home/jdecs/.composer \
    && chown -R jdecs:jdecs /home/jdecs

WORKDIR /var/www

# Copy only composer files for caching
COPY --chown=jdecs:jdecs composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --prefer-dist --optimize-autoloader

# Copy app
COPY --chown=jdecs:jdecs . .

# Supervisor config
COPY docker/conf/supervisord.conf /etc/supervisord.conf

# Entrypoint
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

USER jdecs

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]