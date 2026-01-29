# DigitalMart Laravel Backend - Ubuntu Deployment Guide

## Prerequisites on Ubuntu Server

1. **Apache2 installed and running:**

    ```bash
    sudo apt update
    sudo apt install apache2
    sudo systemctl enable apache2
    sudo systemctl start apache2
    ```

2. **PHP 8.1+ installed:**

    ```bash
    sudo apt install php8.1 php8.1-cli php8.1-common php8.1-mysql php8.1-xml php8.1-mbstring php8.1-curl php8.1-zip php8.1-gd php8.1-tokenizer php8.1-fileinfo php8.1-pcntl
    ```

3. **MySQL/MariaDB installed:**

    ```bash
    sudo apt install mysql-server
    sudo systemctl enable mysql
    sudo systemctl start mysql
    ```

4. **Composer installed:**

    ```bash
    sudo apt install composer
    ```

5. **Node.js installed:**

    ```bash
    sudo apt install nodejs npm
    ```

6. **Enable Apache modules:**
    ```bash
    sudo a2enmod rewrite
    sudo a2enmod headers
    sudo systemctl restart apache2
    ```

## Deployment Steps

### Step 1: Prepare Ubuntu Server

```bash
# Create project directory
sudo mkdir -p /var/www/digitalmart
sudo chown -R $USER:$USER /var/www/digitalmart

# Clone your repository
cd /var/www/digitalmart
git clone your-git-repo-url .
```

### Step 2: Run Deployment Script

```bash
# Make deploy script executable
chmod +x deploy-ubuntu.sh

# Run the deployment script
./deploy-ubuntu.sh
```

### Step 3: Configure Database

```bash
# Login to MySQL
sudo mysql

# Create database and user
CREATE DATABASE digitalmart;
CREATE USER 'admin'@'localhost' IDENTIFIED BY 'your-password';
GRANT ALL PRIVILEGES ON digitalmart.* TO 'admin'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### Step 4: Edit .env File

```bash
nano /var/www/digitalmart/.env
```

Update with your database credentials:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=digitalmart
DB_USERNAME=admin
DB_PASSWORD=your-password
```

### Step 5: Configure Apache Virtual Host

```bash
# Copy Apache config
sudo cp /var/www/digitalmart/apache.conf /etc/apache2/sites-available/digitalmart.conf

# Enable the site
sudo a2ensite digitalmart.conf
sudo a2dissite 000-default.conf

# Test Apache configuration
sudo apache2ctl configtest

# Restart Apache
sudo systemctl restart apache2
```

### Step 6: Set Proper Permissions

```bash
sudo chown -R www-data:www-data /var/www/digitalmart
sudo chmod -R 775 /var/www/digitalmart/storage
sudo chmod -R 775 /var/www/digitalmart/bootstrap/cache
```

## Troubleshooting

### Apache Not Starting

```bash
# Check error logs
sudo tail -f /var/log/apache2/error.log

# Test configuration
sudo apache2ctl configtest
```

### Permission Issues

```bash
# Fix permissions
sudo chown -R www-data:www-data /var/www/digitalmart
sudo chmod -R 775 /var/www/digitalmart/storage
sudo chmod -R 775 /var/www/digitalmart/bootstrap/cache
```

### CORS Errors

Ensure the CORS middleware is properly configured. Check `public/.htaccess` has CORS headers.

### 500 Internal Server Error

```bash
# Check Laravel logs
tail -f /var/www/digitalmart/storage/logs/laravel.log

# Clear caches
php artisan config:clear
php artisan cache:clear
```

## File Structure on Ubuntu

```
/var/www/digitalmart/
├── app/
├── bootstrap/
├── config/
├── database/
├── public/
│   ├── .htaccess (with CORS headers)
│   └── index.php
├── resources/
├── routes/
├── storage/
│   ├── app/public/ (uploaded files)
│   ├── framework/
│   └── logs/
├── vendor/
├── .env
├── composer.json
├── deploy-ubuntu.sh
└── apache.conf
```

## API Endpoints

-   `GET /api/products` - List all products
-   `GET /api/products/{id}` - Get product details
-   `GET /api/categories` - List categories
-   `POST /api/cart/add` - Add to cart
-   `GET /api/cart` - View cart
-   `POST /api/orders` - Create order
-   `GET /api/orders/track` - Track order

## Access Your Application

After deployment, access your application at:

-   **URL:** http://your-server-ip
-   **Admin:** http://your-server-ip/admin/login

## Development vs Production

### Development (on Mac)

```bash
php artisan serve
# Access at http://localhost:8000
```

### Production (on Ubuntu)

```bash
# Use Apache
sudo systemctl restart apache2
# Access at http://your-server-ip
```

## Important Notes

1. **Never commit .env file** - It's in .gitignore for security
2. **Use .env.example** as template for environment variables
3. **Always backup** your database before migrations
4. **Set proper permissions** for storage and bootstrap/cache folders
5. **Enable CORS** for Flutter app to communicate with backend
