#!/usr/bin/env bash
composer install

php artisan storage:link 

chown -R www-data:www-data /var/www

echo "Docker Container is running Successfully" 

# chmod 777 -R storage bootstrap/cache

service php7.4-fpm start

nginx -g 'daemon off;'
