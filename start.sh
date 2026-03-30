#!/bin/sh
cat > /app/.env << EOF
APP_NAME=studyLink
APP_ENV=${APP_ENV:-production}
APP_KEY=${APP_KEY}
APP_DEBUG=${APP_DEBUG:-false}
APP_URL=${APP_URL:-https://studylink-fklm.onrender.com}
DB_CONNECTION=${DB_CONNECTION:-pgsql}
DB_HOST=${DB_HOST}
DB_PORT=${DB_PORT:-5432}
DB_DATABASE=${DB_DATABASE}
DB_USERNAME=${DB_USERNAME}
DB_PASSWORD=${DB_PASSWORD}
SESSION_DRIVER=database
EOF

php artisan config:clear
php artisan migrate --force
sed -i "s/NGINX_PORT/${PORT:-10000}/" /etc/nginx/sites-available/default
php-fpm -D
nginx -g 'daemon off;'