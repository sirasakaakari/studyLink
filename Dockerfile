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

CMD echo "APP_NAME=studyLink" > .env && \
    echo "APP_ENV=${APP_ENV:-production}" >> .env && \
    echo "APP_KEY=${APP_KEY}" >> .env && \
    echo "APP_DEBUG=${APP_DEBUG:-false}" >> .env && \
    echo "APP_URL=${APP_URL:-http://localhost}" >> .env && \
    echo "DB_CONNECTION=${DB_CONNECTION:-pgsql}" >> .env && \
    echo "DB_HOST=${DB_HOST}" >> .env && \
    echo "DB_PORT=${DB_PORT:-5432}" >> .env && \
    echo "DB_DATABASE=${DB_DATABASE}" >> .env && \
    echo "DB_USERNAME=${DB_USERNAME}" >> .env && \
    echo "DB_PASSWORD=${DB_PASSWORD}" >> .env && \
    echo "SESSION_DRIVER=database" >> .env && \
    php artisan migrate --force && \
    php artisan serve --host=0.0.0.0 --port=${PORT:-10000}