FROM php:8.2-apache

RUN apt-get update && apt-get install -y libpng-dev libonig-dev libxml2-dev default-mysql-client zip unzip git && \
    docker-php-ext-install pdo pdo_mysql

COPY . /var/www/html/
COPY docker/apache.conf /etc/apache2/sites-available/000-default.conf

RUN a2enmod rewrite && a2ensite 000-default

RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
