#!/bin/bash

USER_ID=$(id -u)
GROUP_ID=$(id -g)

start() {
    echo "Starting containers..."
    docker-compose up -d
}

local-perm() {
    echo "Setting local permissions..."
    find . ! -path "./storage/*" ! -path "./bootstrap/cache/*" -exec chown $USER_ID:$GROUP_ID {} +
    find . ! -path "./storage/*" ! -path "./bootstrap/cache/*" -exec chmod 775 {} +
}

cache-perm() {
    echo "Setting cache permissions in container..."
    docker exec -it php-fpm bash -c "chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache"
    docker exec -it php-fpm bash -c "chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache"
}

composer-install() {
    echo "Installing Composer dependencies..."
    start
    docker exec -it php-fpm bash -c "composer install"
}

setup-env() {
    echo "Setting up environment file and generating key..."
    start
    docker exec -it php-fpm bash -c "cp .env.example .env"
    docker exec -it php-fpm bash -c "php artisan key:generate"
}

migrate() {
    echo "Running migrations..."
    start
    docker exec -it php-fpm bash -c "php artisan migrate"
}

composer-require() {
    if [ -z "$1" ]; then
        echo "Please provide a package name to install."
        exit 1
    fi
    echo "Installing Composer package: $1"
    start
    docker exec -it php-fpm bash -c "composer require $1"
}

artisan() {
    if [ -z "$1" ]; then
        echo "Please provide an artisan command to run."
        exit 1
    fi
    echo "Running artisan command: php artisan $@"
    start
    docker exec -it php-fpm bash -c "php artisan $@"
    local-perm
    cache-perm
}


route-clear() {
    echo "Clearing route cache..."
    start
    docker exec -it php-fpm bash -c "php artisan route:clear"
    local-perm
    cache-perm
}

case "$1" in
    start)
        start
        ;;
    local-perm)
        local-perm
        ;;
    cache-perm)
        cache-perm
        ;;
    composer-install)
        composer-install
        ;;
    setup-env)
        setup-env
        ;;
    migrate)
        migrate
        ;;
    composer-require)
        shift
        composer-require "$@"
        ;;
    artisan)
        shift
        artisan "$@"
        ;;
    route-clear)
        route-clear
        ;;
    *)
        echo "Usage: $0 {local-perm|start|cache-perm|composer-install|setup-env|migrate|composer-require|artisan|route-clear}"
        exit 1
        ;;
esac
