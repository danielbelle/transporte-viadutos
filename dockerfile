# Usa a imagem base do PHP 8.2 + Apache (conforme seu composer.json)
FROM php:8.2-apache

# Instala dependências do sistema e extensões PHP necessárias
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

# Instala o Composer globalmente (Método oficial)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Define o diretório de trabalho
WORKDIR /var/www/html

# Copia APENAS os arquivos necessários para otimizar o build (evita cache desnecessário)
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --optimize-autoloader --ignore-platform-reqs

# Copia o resto do projeto
COPY . .

# Configura permissões e gera a chave do Laravel (se .env não existir)
RUN if [ ! -f ".env" ]; then cp .env.example .env && php artisan key:generate --force; fi \
    && chmod -R 777 storage bootstrap/cache

# Expõe a porta 80 (Apache)
EXPOSE 80

# Comando para iniciar o Apache
CMD ["apache2-foreground"]
