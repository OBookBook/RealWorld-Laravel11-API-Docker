#!/bin/bash

# Dockerコンテナのビルド
docker-compose build

# Laravelプロジェクトの作成
docker-compose run --rm api composer create-project laravel/laravel .

# Nextプロジェクトの作成
# docker-compose run --rm client npx create-next-app@latest .

# Dockerコンテナの起動
docker-compose up -d

# .envファイルの設定
docker-compose exec api sed -i "s/^DB_CONNECTION=.*/DB_CONNECTION=mysql/" .env
docker-compose exec api sed -i "s/^# DB_HOST=.*/DB_HOST=db/" .env
docker-compose exec api sed -i "s/^# DB_PORT=.*/DB_PORT=3306/" .env
docker-compose exec api sed -i "s/^# DB_DATABASE=.*/DB_DATABASE=laravel/" .env
docker-compose exec api sed -i "s/^# DB_USERNAME=.*/DB_USERNAME=root/" .env
docker-compose exec api sed -i "s/^# DB_PASSWORD=.*/DB_PASSWORD=root/" .env

# Laravelアプリケーションの初期設定
docker-compose exec api php artisan key:generate
docker-compose exec api php artisan storage:link
docker-compose exec api chmod -R 777 storage bootstrap/cache
docker-compose exec api php artisan migrate
