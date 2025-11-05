# Dockerfile
FROM php:8.2-fpm

# Installe les extensions nécessaires
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_pgsql zip

# Installe Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Définit le répertoire de travail
WORKDIR /var/www

# Copie les fichiers du projet
COPY . .

# Donne les permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Installe les dépendances PHP
RUN composer install --no-dev --optimize-autoloader

# Expose le port pour Nginx
EXPOSE 9000

CMD ["php-fpm"]
