# Backend Check Guide for DigitalMart

This document helps you verify that your Laravel backend is correctly configured and accessible.

---

## 1. Quick Backend Test

Run these commands in your terminal to test the backend:

### Test API Connection

```bash
# Test products endpoint
curl http://192.168.100.66/api/products

# Test with verbose output
curl -v http://192.168.100.66/api/products
```

### Expected Response Format

```json
{
    "success": true,
    "data": {
        "current_page": 1,
        "data": [
            {
                "id": 1,
                "name": "Product Name",
                "code_number": "PROD001",
                "price": 100000,
                "stock": 10,
                "image": "products/image.jpg",
                "description": "Product description",
                "category_id": 1
            }
        ],
        "total": 75,
        "last_page": 5,
        "per_page": 16
    }
}
```

---

## 2. Backend Server Check

### Is the server running?

```bash
# Check if Laravel server is running on port 8000
lsof -i :8000

# Or check PHP server
ps aux | grep artisan
```

### Start the server (if not running)

```bash
cd /path/to/your/laravel/backend
php artisan serve --host=0.0.0.0 --port=8000
```

---

## 3. Database Check

### Check if products exist

```bash
# Connect to MySQL
mysql -u root -p

# Check products table
USE digitalmart;
SELECT COUNT(*) FROM products;
SELECT id, name, price, stock FROM products LIMIT 10;
```

### Expected Database Schema

```sql
CREATE TABLE products (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    code_number VARCHAR(255) UNIQUE NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    stock INT DEFAULT 0,
    image VARCHAR(255) NULL,
    category_id BIGINT UNSIGNED NOT NULL,
    description TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

---

## 4. CORS Configuration Check

Ensure your Laravel backend allows requests from the Flutter app:

### Check cors.php config

```php
// config/cors.php
return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],
    'allowed_methods' => ['*'],
    'allowed_origins' => ['*'], // Or specific origins
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => false,
];
```

### Check .env file

```env
APP_URL=http://192.168.100.66:80
SESSION_DOMAIN=.192.168.100.66
SANCTUM_STATEFUL_DOMAINS=192.168.100.66
```

---

## 5. Storage Link Check

Ensure storage is properly linked for images:

```bash
# Check if storage link exists
ls -la /path/to/laravel/backend/public/

# If not, create it
cd /path/to/laravel/backend
php artisan storage:link

# Manual link (if above fails)
ln -s /path/to/laravel/storage/app/public /path/to/laravel/public/storage
```

### Image URL Format

Your backend should return images as:

```
http://192.168.100.66/storage/products/image.jpg
```

---

## 6. Flutter App Debug

### API Test Screen

1. Open the Flutter app
2. Tap the API icon (📡) in the top-right corner
3. Click "Test GET" for the products endpoint
4. Check the Response section for the JSON data

### Check API Client Configuration

File: `lib/core/api/api_constants.dart`

```dart
static const String baseUrl = 'http://192.168.100.66:80/api';
```

### Check Product Model Image URL

File: `lib/features/home/models/product_model.dart`

```dart
String? get imageUrl {
  if (image == null) return null;
  if (image!.startsWith('http')) return image;
  return 'http://192.168.100.66/storage/$image';
}
```

---

## 7. Common Issues & Solutions

### Issue: Connection Timeout

**Solution:**

- Check if backend server is running
- Verify IP address is correct
- Check firewall settings

### Issue: CORS Error

**Solution:**

- Update `config/cors.php`
- Restart Laravel server: `php artisan optimize:clear`

### Issue: Images Not Loading

**Solution:**

- Run `php artisan storage:link`
- Check file permissions: `chmod -R 755 storage`
- Verify image path in database

### Issue: Empty Product List

**Solution:**

- Check database has products: `SELECT COUNT(*) FROM products`
- Check pagination: try `?per_page=100`

### Issue: JSON Parsing Error

**Solution:**

- Verify response format matches expected structure
- Check for `success` field at root level
- Ensure `data` is an object with `data` array inside

---

## 8. Test Script

Create a test script to verify everything:

```bash
#!/bin/bash
# test_backend.sh

echo "=== DigitalMart Backend Test ==="

echo "1. Testing API connection..."
curl -s http://192.168.100.66/api/products > /tmp/products.json

echo "2. Checking response..."
if grep -q '"success":true' /tmp/products.json; then
    echo "✅ API is working!"
    echo "3. Product count:"
    grep -o '"total":[0-9]*' /tmp/products.json
else
    echo "❌ API not responding correctly"
    echo "Response:"
    cat /tmp/products.json
fi

echo "4. Testing image access..."
IMAGE_URL=$(grep -o '"image":"[^"]*"' /tmp/products.json | head -1 | sed 's/"image":"//;s/"//')
if [ ! -z "$IMAGE_URL" ]; then
    echo "Testing image: http://192.168.100.66/storage/$IMAGE_URL"
    curl -s -o /dev/null -w "%{http_code}" "http://192.168.100.66/storage/$IMAGE_URL"
fi
```

---

## 9. Useful Commands

```bash
# Restart Laravel server
php artisan serve

# Clear all caches
php artisan optimize:clear

# Run migrations
php artisan migrate:fresh --seed

# Check routes
php artisan route:list

# Test database connection
php artisan tinker
DB::table('products')->count();
```

---

## 10. Frontend Integration Status

| Feature           | Status        | File                                                             |
| ----------------- | ------------- | ---------------------------------------------------------------- |
| API Connection    | ✅ Working    | `lib/core/api/api_client.dart`                                   |
| Products Endpoint | ✅ Working    | `lib/features/home/presentation/providers/product_provider.dart` |
| Product Model     | ✅ Configured | `lib/features/home/models/product_model.dart`                    |
| Image URLs        | ✅ Configured | Uses `http://192.168.100.66/storage/`                            |
| API Test Screen   | ✅ Available  | Tap 📡 icon on home screen                                       |

---

## 11. Next Steps

1. ✅ Backend is accessible at `http://192.168.100.66:80/api`
2. ✅ API Test GET is working in Flutter app
3. ⏳ Verify products display on home screen
4. ⏳ Test product images loading
5. ⏳ Implement Cart functionality
6. ⏳ Implement Order Tracking

---

**Last Updated:** 2024
**Backend IP:** 192.168.100.66
**API Base URL:** http://192.168.100.66:80/api
