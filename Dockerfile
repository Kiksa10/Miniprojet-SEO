# =====================
# PHP Apache Build
# =====================
FROM php:8.2-apache

# Installer les extensions PostgreSQL pour PHP
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Activer le module rewrite d'Apache (utile pour d'éventuels .htaccess)
RUN a2enmod rewrite

# Copier le code source de l'application dans le répertoire web d'Apache
COPY ./main /var/www/html/main

# Changer le port par défaut si nécessaire ou simplement exposer 80
EXPOSE 80

CMD ["apache2-foreground"]
