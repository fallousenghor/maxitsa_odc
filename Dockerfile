FROM php:8.2-apache

# Installer les extensions nécessaires pour PostgreSQL
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Activer mod_rewrite si besoin
RUN a2enmod rewrite

# Copier les fichiers dans le dossier web Apache
COPY . /var/www/html/

# Définir les bons droits
RUN chown -R www-data:www-data /var/www/html

# Apache s’exécute automatiquement avec cette image
EXPOSE 80
