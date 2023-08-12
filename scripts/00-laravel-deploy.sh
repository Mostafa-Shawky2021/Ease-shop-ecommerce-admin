#!/usr/bin/env bash
echo "Running composer"
composer require
composer update --working-dir=/var/www/html
composer global require hirak/prestissimo

# echo "Caching config..."
# php artisan config:cache

# echo "Caching routes..."
# php artisan route:cache

echo "Running migrations..."
php artisan migrate --force

echo "storage linking"
php artisan storage:link

echo "create new admin"
php artisan make:admin

curl -O -L https://npmjs.org/install.sh | bash

apk add --update nodejs npm
