FROM php:8.2-fpm

# Instalação dependências básicas
RUN apt-get update && apt-get install -y \
    git curl zip unzip \
    && docker-php-ext-install pdo_mysql

# Instalação Node.js LTS (via NodeSource)
RUN curl -fsSL https://deb.nodesource.com/setup_lts.x | bash - \
    && apt-get install -y nodejs

# Instalação Composer
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www