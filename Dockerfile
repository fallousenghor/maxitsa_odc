FROM php:8.2-apache

# Installer les extensions PostgreSQL
RUN apt-get update && apt-get install -y libpq-dev && docker-php-ext-install pdo pdo_pgsql

# Activer mod_rewrite si nécessaire
RUN a2enmod rewrite

# Copier les fichiers du projet
COPY . /var/www/html/

# Droits corrects
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
