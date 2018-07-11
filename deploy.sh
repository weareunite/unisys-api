#!/bin/bash
# Deployment script

php artisan down && git reset --hard HEAD && git pull origin $1;

php artisan clear-compiled;
composer update --optimize-autoloader;

php artisan cache:forget spatie.permission.cache;

php artisan cache:clear;
php artisan route:clear;
php artisan config:clear;

php artisan unisys-api:sync-permissions;

php artisan config:cache;
php artisan route:cache;

php artisan migrate --force;

php artisan up;