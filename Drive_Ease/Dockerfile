# --- STAGE 1: Build Vendor Dependencies ---
FROM composer:2.7 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-scripts --no-autoloader

# --- STAGE 2: Final Application Image ---
FROM php:8.3-fpm

# Set working directory
WORKDIR /var/www

# Install system dependencies & PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libpq-dev \
    && docker-php-ext-install \
    pdo_pgsql \
    pgsql \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip

# Copy composer from previous stage
COPY --from=vendor /usr/bin/composer /usr/bin/composer

# Copy source code
COPY . .

# Copy vendor from previous build
COPY --from=vendor /app/vendor/ ./vendor/

# Set permissions
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Autoload optimization
RUN composer dump-autoload --optimize --no-dev --no-scripts

EXPOSE 9000
CMD ["php-fpm"]
