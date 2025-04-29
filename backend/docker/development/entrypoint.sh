#!/bin/sh

composer install
npm install

if [ ! -f .env ]; then
    cp .env.example .env
    php artisan key:generate
fi

php artisan migrate --force &
php artisan optimize:clear &
npm run dev -- --host 0.0.0.0 &
php-fpm
