FROM php:8.2-fpm

WORKDIR /var/www/laravel

RUN apt-get update && apt-get install -y \
    cron \
    && apt-get clean

RUN docker-php-ext-install pdo pdo_mysql


CMD ["sh", "-c", "service cron start && php-fpm"]
