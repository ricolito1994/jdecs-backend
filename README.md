<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# JDECS BACKEND
## JOHN B LACSON DIGITAL EMPLOYEE CLEARANCE SYSTEM

## REQUIREMENTS
<ul>
    <li>PHP 8+</li>
    <li>Laravel 12</li>
    <li>Docker</li>
    <li>Postman: https://www.postman.com/downloads/</li>
    <li>git/git bash</li>
    <li>MySQL DB</li>
</ul>

## SETUP/INSTALLATION
<ol>
    <li>Install docker for windows: https://docs.docker.com/desktop/setup/install/windows-install/</li>
    <li>Make sure that you have your local MYSQL connection established before installing</li>
    <li>After installation run on your local project directory: docker-compose -f docker-compose.dev.yml up -d</li>
    <li>Wait installation to finish - view in your docker desktop - you should see: </li>
    <li>2025-10-19 08:03:32,052 INFO success: php-fpm entered RUNNING state, process has stayed up for > than 1 seconds (startsecs)</li>
    <li>2025-10-19 08:03:32,053 INFO success: queue-worker entered RUNNING state, process has stayed up for > than 1 seconds (startsecs)</li>
    <li>2025-10-19 08:03:32,054 INFO success: scheduler entered RUNNING state, process has stayed up for > than 1 seconds (startsecs)</li>
</ol>

<img width="1517" height="845" alt="image" src="https://github.com/user-attachments/assets/72827266-f929-486c-80ad-799c0dd0ec1b" />


## DOCKER COMMANDS
<ul>
    <li>to view running containers: docker ps -a</li>
    <li>to SSH to container: docker exec -it (container_name_or_container_id as seen in docker ps -a) bash</li>
    <li>to ssh meaning you access docker container via shell command (command prompt/git bash).
    <li>to remove all docker containers: docker:docker system prune -a --volumes</li>
    <li>to install app: cd to your project folder -> docker-compose -f docker-compose.dev.yml up -d</li>
</ul>

## PHP LARAVEL COMMANDS
<ul>
    <li>To create a controller: php artisan make:controller <controllerName></li>
    <li>To create a model: php artisan make:model <modelName></li>
    <li>To create a migration: php artisan make:model <migrationName> - to create/alter/removee fields or tables</li>
    <li>To run a migration: php artisan migrate</li>
    <li>To undo a migration: php artisan migrate --down</li>
    <li>To undo a seeder: php artisan seed</li>
</ul>

# ROUTE CLEAR
<p>
    if you added a new route via <em>web.php</em>, make sure you ran <b>php artisan route:clear</b>
    to the app container to register the newly added route.
</p>



