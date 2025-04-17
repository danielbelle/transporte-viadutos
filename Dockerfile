# Stage 1: Build frontend assets with Node.js
FROM node:18 as frontend

WORKDIR /app

# 1. Copy only essential files first
COPY package.json package-lock.json ./

# 2. Installation with cache cleaning and fallbacks
RUN npm cache clean --force && \
    npm install --no-audit --legacy-peer-deps

# 3. Copy remaining config files
COPY vite.config.js tailwind.config.js postcss.config.js ./

# 4. Copy resources
COPY resources ./resources

# 5. Build with robust error checking
RUN npm run build --verbose || \
    (echo "Build failed! Debug info:" && \
     echo "Node: $(node -v)" && \
     echo "NPM: $(npm -v)" && \
     echo "Files: $(ls -la)" && \
     echo "Resources content: $(ls -la resources/)" && \
     cat /app/npm-debug.log || true && \
     exit 1)

# 6. Verify generated files
RUN ls -la /app/public/build/

# Stage 2: Build PHP image
FROM php:8.2-fpm as backend

WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nginx \
    supervisor && \
    rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy Laravel files
COPY . .

# Copy built frontend assets
COPY --from=frontend /app/public/build /var/www/html/public/build

# Create minimal .env with required DB config
RUN if [ ! -f .env ]; then \
        cp .env.example .env; \
        echo "DB_CONNECTION=null" >> .env; \
        echo "CACHE_DRIVER=array" >> .env; \
        echo "SESSION_DRIVER=array" >> .env; \
        echo "QUEUE_CONNECTION=sync" >> .env; \
    fi

# Force null database connection in config
RUN echo "<?php return ['default' => null, 'connections' => []];" > config/database.php

# Install Composer dependencies
RUN composer install --optimize-autoloader --no-dev --no-interaction

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache


# Copy config files
COPY nginx.conf /etc/nginx/sites-available/default
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Clean up
RUN apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

EXPOSE 8000
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
