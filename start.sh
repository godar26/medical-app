#!/bin/bash

# Lance PHP-FPM en arrière-plan
php-fpm -D

# Génère la clé app si pas définie
php /var/www/artisan key:generate --force

# Lance les migrations
php /var/www/artisan migrate --force

# Crée le lien storage
php /var/www/artisan storage:link

# Vide les caches
php /var/www/artisan config:cache
php /var/www/artisan route:cache
php /var/www/artisan view:cache

# Lance Nginx
nginx -g "daemon off;"
