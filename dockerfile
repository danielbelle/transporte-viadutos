# Usa a imagem base do PHP 8.4 + Apache (ou 8.2, conforme seu composer.json)
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

# Instala o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Define o diretório de trabalho
WORKDIR /var/www/html

# Copia os arquivos do projeto (exceto o que está no .dockerignore)
COPY . .

# Instala as dependências do Laravel (ignora dev dependencies para produção)
RUN composer install --no-dev --no-scripts --optimize-autoloader \
    && chmod -R 777 storage bootstrap/cache

# Gera a chave do Laravel (se não existir)
RUN if [ ! -f ".env" ]; then cp .env.example .env && php artisan key:generate --force; fi

# Expõe a porta 80 (Apache)
EXPOSE 80

# Comando para iniciar o Apache
CMD ["apache2-foreground"]
