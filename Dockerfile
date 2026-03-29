FROM php:8.2-cli

WORKDIR /app

# 必要パッケージ（pdo_mysqlをpdo_pgsqlに変更）
RUN apt-get update && apt-get install -y \
    git unzip libpq-dev libzip-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# アプリケーションコードコピー
COPY . .

# Laravel 依存パッケージインストール
RUN composer install --no-interaction --optimize-autoloader --prefer-dist --no-dev

# 権限設定
RUN chmod -R 777 storage bootstrap/cache

RUN cp -n .env.example .env || true

EXPOSE 10000

CMD php artisan serve --host=0.0.0.0 --port=${PORT:-10000}