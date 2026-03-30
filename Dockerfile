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

COPY nginx.conf /etc/nginx/sites-available/default
COPY start.sh /start.sh
RUN chmod +x /start.sh

EXPOSE 10000

CMD ["/start.sh"]