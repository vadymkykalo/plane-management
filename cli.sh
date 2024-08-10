#!/bin/bash

set -e

npm-install() {
  echo "Installing Npm requirements"
  docker-compose run --rm node npm install
}

npm-install-package() {
    if [ -z "$1" ]; then
        echo "Please provide a package name to install."
        exit 1
    fi
    echo "Installing npm package: $1"
    docker-compose run --rm node npm install "$1"
}

upd-perm() {
  echo "Update permissions"

  GRP_ID=$(id -g)
  docker-compose run --rm --user=root php-fpm chown www-data . -R
  docker-compose run --rm --user=root php-fpm chgrp "$GRP_ID" . -R
  docker-compose run --rm --user=root php-fpm chmod g+rwx . -R
}

composer-install() {
    echo "Installing Composer requirements"
    docker-compose run --rm --user=root php-fpm composer install
}

composer-require() {
    if [ -z "$1" ]; then
        echo "Please provide a package name to install."
        exit 1
    fi
    echo "Installing Composer package: $1"

    docker-compose run --rm php-fpm composer require "$1"
}

public-storage-perm() {
  echo "Update public permissions"
  sudo chmod -R a+rwx ./backend/storage
}

cp-env() {
    echo "Setting up environment file and generating key..."
    docker-compose run --rm --user=root php-fpm bash -c "chown www-data:www-data /var/www/html -R && chmod -R 775 /var/www/html && cp .env.example .env && php artisan key:generate"
}

migrate() {
    echo "Run migrations"
    docker-compose run --rm php-fpm php artisan migrate
}

artisan() {
    if [ -z "$1" ]; then
        echo "Please provide an artisan command to run."
        exit 1
    fi
    echo "Running artisan command: php artisan $@"
    docker-compose run --rm php-fpm php artisan "$@"
}

load-db() {
  artisan db:seed --class=DatabaseSeeder
}

start() {
  docker-compose up -d
}

stop() {
  docker-compose stop
}

down() {
  docker-compose down -v
}

ps() {
  docker-compose ps
}

setup() {
  echo "Start ..."

  echo "Build image .."
  docker-compose build

  composer-install
  cp-env
  public-storage-perm

  docker-compose up -d db
  docker-compose up -d php-fpm
  docker-compose up -d nginx

  migrate

  npm-install
  docker-compose up -d node

  echo "Done!"
}

_message() {
    echo "=> $1"
}

_help() {
  echo "Usage examples: "
  IFS=$'\n'
  for f in $(declare -F); do
    ( [ "${f:9:2}" == "fx" ] || [ "${f:11:1}" == "_" ] ) && continue;
    echo "  ./cli ${f:11}"
  done

  echo
}

if [ -z "$1" ]; then
  _help
  exit 1
fi

"$@"
