# DigitalMart Project - Task Tracker

## Flutter App Implementation ✅ COMPLETED

### 1. Dependencies (pubspec.yaml) ✅

-   `http` - API calls
-   `flutter_riverpod` - State management
-   `shared_preferences` - Session persistence
-   `fluttertoast` - Notifications
-   `badges` - Cart badge
-   `uuid` - Generate unique IDs

### 2. Project Structure ✅

```
lib/
├── main.dart
├── models/
│   ├── product.dart
│   ├── category.dart
│   ├── cart_item.dart
│   └── order.dart
├── services/
│   └── api_service.dart
├── providers/
│   ├── products_provider.dart
│   ├── cart_provider.dart
│   └── categories_provider.dart
├── screens/
│   ├── home_screen.dart
│   ├── product_detail_screen.dart
│   ├── cart_screen.dart
│   ├── checkout_screen.dart
│   ├── order_tracking_screen.dart
│   └── category_products_screen.dart
├── widgets/
│   ├── product_card.dart
│   ├── cart_item_widget.dart
│   └── category_chip_widget.dart
└── utils/
    └── constants.dart
```

## Implementation Steps ✅ COMPLETED

-   [x] Step 1: Update pubspec.yaml
-   [x] Step 2: Create models (product, category, cart_item, order)
-   [x] Step 3: Create constants.dart
-   [x] Step 4: Create api_service.dart
-   [x] Step 5: Create Riverpod providers
-   [x] Step 6: Create widgets
-   [x] Step 7: Create screens
-   [x] Step 8: Update main.dart
-   [x] Step 9: Fix all analysis errors

## API Endpoints to Use

-   GET `/api/products?page=&search=&category=`
-   GET `/api/products/{id}`
-   GET `/api/categories`
-   GET `/api/categories/{id}`
-   GET `/api/cart`
-   POST `/api/cart/add`
-   PUT `/api/cart/update`
-   DELETE `/api/cart/remove`
-   DELETE `/api/cart/clear`
-   POST `/api/orders`
-   GET `/api/orders/track?order_number=&phone=`

---

## Ubuntu Backend Deployment 🚀 IN PROGRESS

### Deployment Setup

-   [x] Create deploy-ubuntu.sh script
-   [x] Create apache.conf for virtual host
-   [x] Create README_DEPLOYMENT.md guide
-   [x] Create .env.example template

### On Ubuntu Server - Steps to Execute

1. **Push to GitHub:**

    ```bash
    git add .
    git commit -m "Add Ubuntu deployment files"
    git push origin main
    ```

2. **On Ubuntu Server:**

    ```bash
    cd /var/www/digitalmart
    git pull origin main

    # Make deploy script executable
    chmod +x deploy-ubuntu.sh

    # Run deployment
    ./deploy-ubuntu.sh

    # Configure database
    # Edit .env with database credentials

    # Configure Apache
    sudo cp apache.conf /etc/apache2/sites-available/digitalmart.conf
    sudo a2ensite digitalmart.conf
    sudo systemctl restart apache2
    ```

### Files Created for Ubuntu Deployment

| File                   | Purpose                           |
| ---------------------- | --------------------------------- |
| `deploy-ubuntu.sh`     | Automated deployment script       |
| `apache.conf`          | Apache virtual host configuration |
| `README_DEPLOYMENT.md` | Complete deployment guide         |
| `.env.example`         | Environment template for Ubuntu   |

### Ubuntu Server Requirements

-   [ ] Apache2 with mod_rewrite and mod_headers enabled
-   [ ] PHP 8.1+ with extensions
-   [ ] MySQL/MariaDB
-   [ ] Composer
-   [ ] Node.js and npm

---

## Development Commands

### Mac (Development)

```bash
# Start Laravel server
php artisan serve

# Start Flutter app
flutter run
```

### Ubuntu (Production)

```bash
# Restart Apache
sudo systemctl restart apache2

# Check Apache status
sudo systemctl status apache2

# View Laravel logs
tail -f storage/logs/laravel.log
```

---

## CORS Configuration ✅

CORS is handled in:

-   `public/.htaccess` - Static files (images, CSS, JS)
-   `app/Http/Middleware/AddCorsHeaders.php` - API requests
