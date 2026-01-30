FROM php:8.2-apache

# 1. Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl

# 2. Install PHP extensions required by Laravel
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# 3. Enable Apache mod_rewrite (Laravel Route တွေအတွက် မရှိမဖြစ်ပါ)
RUN a2enmod rewrite

# 4. Apache DocumentRoot ကို /public သို့ ပြောင်းခြင်း
# (Laravel က public folder ကနေ run ရလို့ပါ)
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# 5. Cloud Run အတွက် Port 8080 သို့ ပြောင်းခြင်း
RUN sed -i 's/Listen 80/Listen 8080/' /etc/apache2/ports.conf
RUN sed -i 's/:80/:8080/' /etc/apache2/sites-available/000-default.conf

# 6. Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 7. Copy Project Files
WORKDIR /var/www/html
COPY . .

# 8. Install PHP Dependencies via Composer
# (Vendor folder ဆောက်ပေးမယ့် အပိုင်းပါ)
RUN composer install --no-dev --optimize-autoloader

# 9. Set Permissions for Laravel Storage
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 10. Start Apache
CMD ["apache2-foreground"]