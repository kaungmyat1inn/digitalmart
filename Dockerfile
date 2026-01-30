# PHP 8.2 ကို အခြေခံပါမယ်
FROM php:8.2

# 1. System Tools များနှင့် Node.js သွင်းရန် လိုအပ်သည်များ
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    gnupg

# 2. Node.js (Version 20) ကို Install လုပ်ပါမယ် (Vite Build အတွက်)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y nodejs

# 3. Laravel အတွက် PHP Extensions များ
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# 4. Composer သွင်းပါမယ်
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 5. အလုပ်လုပ်မယ့် နေရာ
WORKDIR /var/www

# 6. ဖိုင်တွေ အကုန်ကူးထည့်ပါမယ်
COPY . /var/www

# 7. PHP Library တွေ Install လုပ်ပါမယ်
RUN composer install --no-dev --optimize-autoloader

# 8. Frontend Assets (CSS/JS) တွေကို Build လုပ်ပါမယ် (အရေးကြီးဆုံးအဆင့်) 🔥
RUN npm install
RUN npm run build

# 9. Server Run ပါမယ်
CMD sh -c "php artisan migrate --force && php artisan serve --host 0.0.0.0 --port $PORT"