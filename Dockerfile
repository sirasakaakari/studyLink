# Dockerfile
FROM php:8.2-cli

WORKDIR /app

# 必要なパッケージ
RUN apt-get update && apt-get install -y \
    git unzip libpq-dev libzip-dev \
    && docker-php-ext-install pdo pdo_mysql

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Laravel プロジェクトコピー
COPY . .

# 権限設定
RUN chmod -R 777 storage bootstrap/cache

# デフォルトコマンド
CMD php artisan serve --host=0.0.0.0 --port=8000