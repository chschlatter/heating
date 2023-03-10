FROM php:8-apache
WORKDIR /var/www/html

COPY . .
RUN chown -R www-data /var/www/html/public/uploads
COPY ./apache/000-default.conf /etc/apache2/sites-available/000-default.conf

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
RUN apt-get update && apt-get install -y unzip && composer install

# RUN apt-get update && apt-get install -y sqlite3

# WORKDIR /data
RUN mkdir /data && touch /data/database.db && chown -R www-data /data
VOLUME /data

EXPOSE 80
