#!/bin/bash

set -e

npm-install() {
#  docker run --rm -v $(pwd)/frontend:/app -w /app node:18 npm install
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

update-permissions() {
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

setup-env() {
    echo "Setting up environment file and generating key..."
    docker-compose run --rm php-fpm bash -c "cp .env.example .env"
    docker-compose run --rm php-fpm bash -c "php artisan key:generate"
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

start() {
  docker-compose up -d
}

stop() {
  docker-compose stop
}

down() {
  docker-compose down -v
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
