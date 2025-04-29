#!/bin/sh

composer install
npm install

php artisan migrate --force &
php artisan optimize:clear &
npm run dev -- --host 0.0.0.0 &
php-fpm
