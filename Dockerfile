# Utilisez une image de base avec PHP et Composer préinstallés
FROM php:7.4-fpm

# Définissez le répertoire de travail dans le conteneur
WORKDIR .

# Installez les dépendances de Laravel
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    && docker-php-ext-install zip

# Copiez les fichiers du projet dans le conteneur
COPY . .

# Installez les dépendances de Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-scripts

# Générez la clé d'application Laravel
RUN php artisan key:generate
