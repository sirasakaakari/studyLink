FROM php:8.2-cli

WORKDIR /app

RUN apt-get update && apt-get install -y \
    git unzip libpq-dev libzip-dev \
    && docker-php-ext-install pdo pdo_pgsql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer install --no-interaction --optimize-autoloader --prefer-dist --no-dev

RUN chmod -R 777 storage bootstrap/cache

EXPOSE 10000

# 起動時に環境変数を.envに反映してからサーバー起動
CMD cp .env.example .env && \
    php artisan key:generate && \
    php artisan serve --host=0.0.0.0 --port=${PORT:-10000}