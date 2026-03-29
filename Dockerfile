FROM php:8.2-fpm

WORKDIR /app

RUN apt-get update && apt-get install -y \
    git unzip libpq-dev libzip-dev curl nginx \
    && docker-php-ext-install pdo pdo_pgsql \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer install --no-interaction --optimize-autoloader --prefer-dist --no-dev

RUN npm install && npm run build

RUN chmod -R 777 storage bootstrap/cache

# ここでCOPY！CMDより前に置く
COPY nginx.conf /etc/nginx/sites-available/default

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
    sed -i "s/NGINX_PORT/${PORT:-10000}/" /etc/nginx/sites-available/default && \
    php-fpm -D && \
    nginx -g 'daemon off;'