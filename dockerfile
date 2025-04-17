FROM php:8.2-apache

# 1. Instala dependências ESSENCIAIS
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip \
    && a2enmod rewrite

# 2. Instalação À PROVA DE FALHAS do Composer
RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin \
    --filename=composer \
    --version=2.7.1

# 3. Otimização do Build
WORKDIR /var/www/html
COPY composer.json composer.lock .
RUN composer install --no-dev --no-scripts --optimize-autoloader --ignore-platform-reqs

# 4. Copia o resto da aplicação
COPY . .

# 5. Configuração Final
RUN chmod -R 777 storage bootstrap/cache
EXPOSE 80
CMD ["apache2-foreground"]
RUN which composer && composer --version
ENV PATH="${PATH}:/root/.composer/vendor/bin"
