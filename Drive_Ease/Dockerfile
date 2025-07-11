# --- STAGE 1: Build Vendor Dependencies ---
# Tahap ini hanya fokus untuk membuat folder 'vendor'
FROM composer:2.7 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
# Hanya install dependensi, tanpa menjalankan skrip Laravel apa pun
RUN composer install --no-scripts --no-autoloader

# --- STAGE 2: Build Final Application Image ---
# Tahap ini membangun image akhir yang akan dijalankan
FROM php:8.3-fpm

# Set working directory
WORKDIR /var/www

# Install system packages & all required PHP extensions dalam satu langkah
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    && docker-php-ext-install \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip

# Copy Composer binary dari stage pertama
COPY --from=vendor /usr/bin/composer /usr/bin/composer

# Copy application source code dari direktori lokal Anda
COPY . .

# Copy folder 'vendor' yang sudah jadi dari stage pertama
# INI ADALAH LANGKAH KUNCI YANG SEBELUMNYA HILANG
COPY --from=vendor /app/vendor/ ./vendor/

# Set izin yang benar untuk folder storage dan cache
# Cukup jalankan satu kali setelah semua file disalin
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Buat ulang autoload file yang dioptimalkan dari folder vendor yang ada
# Kita tidak perlu 'composer install' lagi, cukup dump-autoload
RUN composer dump-autoload --optimize --no-dev --no-scripts

# Expose port dan jalankan service php-fpm
EXPOSE 9000
CMD ["php-fpm"]