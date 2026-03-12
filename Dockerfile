# Pakai mesin PHP 8.2 + Web Server Apache bawaan
FROM php:8.2-apache

# Install tool tambahan yang dibutuhkan Laravel (Ditambah CURL untuk mengunduh Node.js)
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    curl \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && docker-php-ext-install pdo pdo_mysql gd

# Aktifkan mod_rewrite Apache (wajib untuk routing Laravel)
RUN a2enmod rewrite

# Ganti lokasi default Apache ke folder /public Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Copy semua file KosLink dari laptopmu ke dalam Docker
WORKDIR /var/www/html
COPY . .

# Install Composer (untuk mengunduh vendor PHP/Laravel)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# === INI BAGIAN BARU: MEMASAK TAMPILAN DEPAN (VITE) ===
RUN npm install
RUN npm run build
# ======================================================

# === INI BAGIAN BARU: MEMBUAT JEMBATAN FOTO ===
RUN php artisan storage:link
# ==============================================

# Atur izin folder agar Laravel bisa upload gambar dan bikin cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Buka port 80 untuk web
EXPOSE 80