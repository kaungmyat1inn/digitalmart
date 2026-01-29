# CORS Fix for Ubuntu Laravel Backend

Since your Laravel backend is on Ubuntu and you're developing on Mac, follow these steps to fix CORS:

## Step 1: SSH to your Ubuntu server

```bash
ssh your-username@192.168.100.66
```

## Step 2: Edit the Apache .htaccess file on Ubuntu

Navigate to your Laravel public directory:

```bash
cd /path/to/your/laravel/project/public
```

Edit the .htaccess file:

```bash
sudo nano .htaccess
```

Replace the entire content with:

```
# CORS Headers - MUST be at the top for all requests
<IfModule mod_headers.c>
    Header set Access-Control-Allow-Origin "*"
    Header set Access-Control-Allow-Methods "GET, POST, PUT, PATCH, DELETE, OPTIONS"
    Header set Access-Control-Allow-Headers "Content-Type, Authorization, X-Requested-With, Cookie"
    Header set Access-Control-Expose-Headers "Set-Cookie"
    Header set Access-Control-Max-Age "86400"
</IfModule>

<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle CORS preflight OPTIONS requests
    RewriteCond %{REQUEST_METHOD} OPTIONS
    RewriteRule .* - [R=204,L]

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

## Step 3: Also add .htaccess to storage folder

```bash
cd /path/to/your/laravel/project/storage/app/public
sudo nano .htaccess
```

Add:

```
# CORS Headers for Storage Files
<IfModule mod_headers.c>
    Header set Access-Control-Allow-Origin "*"
    Header set Access-Control-Allow-Methods "GET, OPTIONS"
    Header set Access-Control-Allow-Headers "Content-Type, Authorization, X-Requested-With"
    Header set Access-Control-Max-Age "86400"
</IfModule>

# Disable directory listing
Options -Indexes
```

## Step 4: Restart Apache

```bash
sudo systemctl restart apache2
```

## Step 5: Verify CORS is working

From your Mac, test the API:

```bash
curl -I -H "Origin: http://localhost:63743" "http://192.168.100.66:8000/api/products"
```

You should see:

```
Access-Control-Allow-Origin: *
```

Test image loading:

```bash
curl -I -H "Origin: http://localhost:63743" "http://192.168.100.66:8000/storage/products/your-image.jpg"
```

## Alternative: Using Laravel CORS Package

If you prefer using Laravel's built-in CORS handling:

### 1. Install fruitcake/laravel-cors

```bash
composer require fruitcake/laravel-cors
```

### 2. Publish config

```bash
php artisan vendor:publish --tag="cors"
```

### 3. Edit config/cors.php

```php
'paths' => ['api/*', 'storage/*'],

'allowed_methods' => ['*'],

'allowed_origins' => ['*'],

'allowed_headers' => ['*'],

'exposed_headers' => [],

'max_age' => 0,

'supports_credentials' => true,
```

### 4. Update Kernel.php

In `app/Http/Kernel.php`, make sure HandleCors is in the global middleware:

```php
protected $middleware' => [
    \Fruitcake\Cors\HandleCors::class,
    // ... other middleware
];
```

Then restart Laravel:

```bash
php artisan optimize:clear
sudo systemctl restart apache2
```

## Quick Copy-Paste for Ubuntu Server

Run this on your Ubuntu server to apply the fix automatically:

```bash
# Backup current .htaccess
cp /path/to/laravel/public/.htaccess /path/to/laravel/public/.htaccess.bak

# Write new .htaccess
cat > /path/to/laravel/public/.htaccess << 'EOF'
# CORS Headers
<IfModule mod_headers.c>
    Header set Access-Control-Allow-Origin "*"
    Header set Access-Control-Allow-Methods "GET, POST, PUT, PATCH, DELETE, OPTIONS"
    Header set Access-Control-Allow-Headers "Content-Type, Authorization, X-Requested-With, Cookie"
    Header set Access-Control-Max-Age "86400"
</IfModule>

<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_METHOD} OPTIONS
    RewriteRule .* - [R=204,L]
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
EOF

# Restart Apache
sudo systemctl restart apache2
```
