# Stage 1: Build frontend assets with Node.js
FROM node:18 as frontend

WORKDIR /app
COPY package.json package-lock.json vite.config.js tailwind.config.js /app/
COPY resources /app/resources/

RUN npm ci --no-audit && \
    npm run build && \
    ls -la /app/public/build/  # Verifique se os arquivos foram gerados

# Stage 2: Build PHP image
FROM php:8.2-fpm as backend

WORKDIR /var/www/html

# Install system dependencies (keep existing)
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nginx \
    supervisor

# Install PHP extensions (REMOVE pdo_mysql)
RUN docker-php-ext-install mbstring exif pcntl bcmath gd

# Install Composer (keep existing)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy Laravel files (keep existing)
COPY . .

# Copy built frontend assets (keep existing)
COPY --from=frontend /app/public/build /var/www/html/public/build

# Create minimal .env with required DB config
RUN if [ ! -f .env ]; then \
        cp .env.example .env; \
        echo "DB_CONNECTION=null" >> .env; \
        echo "CACHE_DRIVER=array" >> .env; \
        echo "SESSION_DRIVER=array" >> .env; \
    fi

# Force null database connection in config
RUN echo "<?php return ['default' => null, 'connections' => []];" > config/database.php

# Install Composer dependencies (keep existing)
RUN composer install --optimize-autoloader --no-dev

# Set permissions (keep existing)
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Copy config files (keep existing)
COPY nginx.conf /etc/nginx/sites-available/default
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

EXPOSE 8000
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
