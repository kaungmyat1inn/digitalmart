#!/bin/bash

# Laravel Ubuntu Deployment Script
# Run this script on your Ubuntu server after pulling the code

echo "🚀 Starting Laravel Deployment on Ubuntu..."

# Get the directory where the script is running
PROJECT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
echo "📁 Project directory: $PROJECT_DIR"

# Navigate to project directory
cd "$PROJECT_DIR"

# 1. Install PHP dependencies
echo "📦 Installing Composer dependencies..."
composer install --no-interaction --prefer-dist --optimize-autoloader

# 2. Install Node dependencies (if package.json exists)
if [ -f "package.json" ]; then
    echo "📦 Installing NPM dependencies..."
    npm install --no-interaction
    echo "⚡ Building assets..."
    npm run build
fi

# 3. Copy environment file if .env doesn't exist
if [ ! -f ".env" ]; then
    echo "📝 Creating .env file from template..."
    cp .env.example .env
    echo "⚠️  IMPORTANT: Edit .env with your database credentials!"
else
    echo "✅ .env file already exists"
fi

# 4. Generate application key
echo "🔑 Generating application key..."
php artisan key:generate --force

# 5. Clear and cache configuration
echo "🧹 Clearing caches..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

echo "⚡ Caching configuration for production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 6. Run database migrations
echo "🗄️  Running database migrations..."
php artisan migrate --force

# 7. Seed database (optional - comment out if not needed)
# echo "🌱 Seeding database..."
# php artisan db:seed --force

# 8. Create storage link
echo "🔗 Creating storage link..."
php artisan storage:link

# 9. Set proper permissions
echo "🔐 Setting permissions..."
sudo chown -R www-data:www-data "$PROJECT_DIR"
sudo chmod -R 775 "$PROJECT_DIR/storage"
sudo chmod -R 775 "$PROJECT_DIR/bootstrap/cache"
sudo chmod -R 775 "$PROJECT_DIR/public"

# 10. Restart Apache
echo "🔄 Restarting Apache..."
sudo systemctl restart apache2

echo ""
echo "✅ Deployment completed successfully!"
echo ""
echo "📋 Next steps:"
echo "   1. Edit .env file with your database credentials"
echo "   2. Configure Apache virtual host (see apache.conf)"
echo "   3. Test your application at http://your-server-ip"
echo ""

