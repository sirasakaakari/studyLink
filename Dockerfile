FROM php:8.2-cli

WORKDIR /app

# 必要パッケージ
RUN apt-get update && apt-get install -y \
    git unzip libpq-dev libzip-dev \
    && docker-php-ext-install pdo pdo_mysql

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# アプリケーションコードコピー
COPY . .

# Laravel 依存パッケージインストール
RUN composer install --no-interaction --optimize-autoloader --prefer-dist --no-dev

# 権限設定
RUN chmod -R 777 storage bootstrap/cache

# 起動コマンド
CMD php artisan serve --host=0.0.0.0 --port=${PORT:-8000}