# Backend Issues - TODO

## Issue: CORS Policy Blocking Image Requests

### Problem

The Flutter app is getting CORS errors when loading images:

```
Access to XMLHttpRequest at 'http://192.168.100.66:8000/storage/products/...'
from origin 'http://localhost:61680' has been blocked by CORS policy:
No 'Access-Control-Allow-Origin' header is present on the requested resource.
```

### Root Cause

When running Flutter in a browser environment (e.g., `flutter run -d chrome`), the browser enforces CORS policies. The server at `http://192.168.100.66:8000` is not sending the required `Access-Control-Allow-Origin` headers for static files (images).

### Flutter Client Fix (Implemented) ✅

The Flutter app has been updated to use `HttpImage` widget instead of `Image.network()`. This uses Dart's HTTP client directly (bypassing browser CORS restrictions) to load images.

**Files Updated:**

- `lib/widgets/product_card.dart` - Uses `HttpImage` for product thumbnails
- `lib/screens/product_detail_screen.dart` - Uses `HttpImage` for product image
- `lib/widgets/cart_item_widget.dart` - Uses `HttpImage` for cart item images

### Backend Fix (Recommended for Production)

To properly support browser-based Flutter apps and ensure all cross-origin requests work, add CORS headers to your Laravel backend.

#### Step 1: Install laravel-cors package

```bash
composer require fruitcake/laravel-cors
```

#### Step 2: Publish config

```bash
php artisan vendor:publish --tag="cors"
```

#### Step 3: Update config/cors.php

```php
'paths' => [
    'api/*',
    'storage/*',  // Add this for static files
],

'allowed_methods' => [
    'GET',
    'POST',
    'PUT',
    'PATCH',
    'DELETE',
    'OPTIONS',
],

'allowed_origins' => [
    'http://localhost:61680',
    'http://localhost:53575',  // Common Flutter web ports
    'http://127.0.0.1:53575',
],

'allowed_origins_patterns' => [],

'allowed_headers' => [
    'Content-Type',
    'Authorization',
    'X-Requested-With',
    'Cookie',
],

'exposed_headers' => [
    'Set-Cookie',
],

'max_age' => 0,

'supports_credentials' => true,
```

#### Step 4: Apply CORS to Nginx/Apache

If using Nginx, add headers to your server block:

```nginx
location /storage/ {
    add_header 'Access-Control-Allow-Origin' '*';
    add_header 'Access-Control-Allow-Methods' 'GET, OPTIONS';
    add_header 'Access-Control-Allow-Headers' 'Content-Type';
    try_files $uri $uri/ /index.php?$query_string;
}
```

For Apache, add to `.htaccess`:

```apache
<IfModule mod_headers.c>
    <FilesMatch "\.(jpg|jpeg|png|gif|ico|css|js)$">
        Header set Access-Control-Allow-Origin "*"
    </FilesMatch>
</IfModule>
```

### Quick Test: Enable CORS in Laravel Middleware

Add to `app/Http/Kernel.php`:

```php
protected $middlewareGroups = [
    'api' => [
        \Fruitcake\Cors\HandleCors::class,
        // ... other middleware
    ],
];
```

Create a middleware for static files in `app/Http/Middleware/AddCorsHeaders.php`:

```php
public function handle($request, Closure $next) {
    $response = $next($request);
    $response->headers->set('Access-Control-Allow-Origin', '*');
    $response->headers->set('Access-Control-Allow-Methods', 'GET, OPTIONS');
    $response->headers->set('Access-Control-Allow-Headers', 'Content-Type');
    return $response;
}
```

Register in `Http/Kernel.php` for `web` middleware group:

```php
protected $middlewareGroups = [
    'web' => [
        // ...
        \App\Http\Middleware\AddCorsHeaders::class,
    ],
];
```

### Why HttpImage Works

The `HttpImage` widget uses Dart's `http` package directly instead of the browser's `fetch` API. This bypasses browser CORS enforcement because:

1. Dart's HTTP client runs outside the browser's security context
2. It can access any URL that doesn't require CORS headers
3. Images are loaded as binary data and converted to Uint8List
4. The data is then rendered using `Image.memory()` instead of `Image.network()`

### Note for Mobile Apps

On iOS/Android, `Image.network()` works fine because mobile apps don't enforce CORS. The CORS issue only affects:

- Flutter Web
- Browser-based deployments
- Any web-based runtime

### Summary

✅ **Flutter App**: Fixed by using `HttpImage` widget
🔲 **Backend**: Should be configured with CORS headers for production
