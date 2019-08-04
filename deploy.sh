#!/usr/bin/env bash

#docker-compose up -d --build

#docker exec -it laravelvv composer update
cp ./.env.example ./.env
docker exec -it laravelvv php artisan migrate
docker exec -it laravelvv php artisan getdata2api
docker exec -it laravelvv chmod -Rf 777 storage
docker exec -it laravelvv vendor/bin/phpunit
