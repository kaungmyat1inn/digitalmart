# PHP 8.2 ကို အခြေခံပါမယ်
FROM php:8.2

# လိုအပ်တဲ့ System Tools တွေ သွင်းပါမယ်
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Laravel အတွက် လိုအပ်တဲ့ PHP Extension တွေ သွင်းပါမယ်
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Composer သွင်းပါမယ်
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# အလုပ်လုပ်မယ့် နေရာ သတ်မှတ်ပါမယ်
WORKDIR /var/www

# ဖိုင်တွေ အကုန်ကူးထည့်ပါမယ်
COPY . /var/www

# Laravel Library တွေ Install လုပ်ပါမယ်
RUN composer install --no-dev --optimize-autoloader

# Server Run ပါမယ် (Render က ပေးတဲ့ PORT ကို သုံးပါမယ်)
CMD sh -c "php artisan migrate --force && php artisan serve --host 0.0.0.0 --port $PORT"