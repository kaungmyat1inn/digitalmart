FROM php:8.2-apache

# 1. Install system dependencies (Node.js ပါ ထည့်သွင်းမည်)
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    gnupg

# Node.js (Version 18) ကို install လုပ်ခြင်း
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs

# 2. Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# 3. Enable Apache mod_rewrite
RUN a2enmod rewrite

# 4. Set Apache DocumentRoot
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf
RUN sed -i 's/Listen 80/Listen 8080/' /etc/apache2/ports.conf
RUN sed -i 's/:80/:8080/' /etc/apache2/sites-available/000-default.conf

# 5. Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 6. Copy Project Files
WORKDIR /var/www/html
COPY . .

# 7. Install PHP Dependencies
RUN composer install --no-dev --optimize-autoloader

# 8. Install Node Dependencies & Build Assets (ဒီအဆင့် အရေးကြီးဆုံးပါ)
RUN npm install
RUN npm run build

# 9. Set Permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 10. Start Apache
CMD ["apache2-foreground"]