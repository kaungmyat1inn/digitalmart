# Flutter App REST API Integration TODO

## ✅ Backend API Endpoints (COMPLETED)

### Public Endpoints (No Auth Required) ✅

1. **Products API**

    - [x] GET `/api/products` - List products with pagination, search, category filter
    - [x] GET `/api/products/{id}` - Get single product details
    - [x] GET `/api/categories` - List all categories
    - [x] GET `/api/categories/{id}` - Get category with products

2. **Cart API** (Session-based) ✅

    - [x] GET `/api/cart` - Get cart contents
    - [x] POST `/api/cart/add` - Add item to cart
    - [x] PUT `/api/cart/update` - Update cart item quantity
    - [x] DELETE `/api/cart/remove` - Remove item from cart
    - [x] DELETE `/api/cart/clear` - Clear cart

3. **Orders API** ✅
    - [x] POST `/api/orders` - Create new order (guest checkout)
    - [x] GET `/api/orders/{id}` - Get order details
    - [x] GET `/api/orders/track?order_number=&phone=` - Track order by number and phone

### Admin Endpoints (Auth Required via Sanctum) ✅

4. **Auth API** ✅

    - [x] POST `/api/admin/login` - Admin login
    - [x] POST `/api/admin/logout` - Admin logout
    - [x] GET `/api/admin/me` - Get current admin user

5. **Admin Dashboard API** ✅

    - [x] GET `/api/admin/dashboard` - Dashboard statistics

6. **Admin Orders API** ✅

    - [x] GET `/api/admin/orders` - List all orders
    - [x] GET `/api/admin/orders/{id}` - Get order details
    - [x] PUT `/api/admin/orders/{id}/status` - Update order status

7. **Admin Products API** ✅

    - [x] GET `/api/admin/products` - List all products
    - [x] POST `/api/admin/products` - Create product
    - [x] PUT `/api/admin/products/{id}` - Update product
    - [x] DELETE `/api/admin/products/{id}` - Delete product

8. **Admin Categories API** ✅
    - [x] GET `/api/admin/categories` - List all categories
    - [x] POST `/api/admin/categories` - Create category
    - [x] PUT `/api/admin/categories/{id}` - Update category
    - [x] DELETE `/api/admin/categories/{id}` - Delete category

## 🛠️ Flutter App Integration Steps

### 1. Install Dependencies

Add these to `pubspec.yaml`:

```yaml
dependencies:
    http: ^1.1.0
    shared_preferences: ^2.2.2
    provider: ^6.0.5
    # For state management (or use Riverpod/Bloc)
```

### 2. API Base URL

```dart
const String kBaseUrl = 'https://your-domain.com/api';
```

### 3. Authentication Flow (Admin Only)

```dart
// Login
final response = await http.post(
  Uri.parse('$kBaseUrl/admin/login'),
  body: {'email': email, 'password': password},
);
if (response.statusCode == 200) {
  final token = jsonDecode(response.body)['token'];
  // Save token to secure storage
}
```

### 4. Products Screen

```dart
// GET /api/products?search=...&category=...&page=...
final response = await http.get(
  Uri.parse('$kBaseUrl/products?page=1'),
);
```

### 5. Cart Management

```dart
// Add to cart
final response = await http.post(
  Uri.parse('$kBaseUrl/cart/add'),
  body: {'product_id': id, 'quantity': 1},
  headers: {'Cookie': 'your-session-cookie'},
);
```

### 6. Checkout

```dart
// Create order
final response = await http.post(
  Uri.parse('$kBaseUrl/orders'),
  body: {
    'customer_name': name,
    'customer_phone': phone,
    'address': address,
    'items': jsonEncode(cartItems),
  },
);
```

## 📱 Flutter Project Structure Suggestion

```
lib/
├── models/
│   ├── product.dart
│   ├── category.dart
│   ├── cart_item.dart
│   └── order.dart
├── services/
│   ├── api_service.dart
│   ├── auth_service.dart
│   └── cart_service.dart
├── providers/
│   ├── cart_provider.dart
│   └── auth_provider.dart
├── screens/
│   ├── home_screen.dart
│   ├── product_detail_screen.dart
│   ├── cart_screen.dart
│   ├── checkout_screen.dart
│   ├── order_tracking_screen.dart
│   └── admin/
│       ├── login_screen.dart
│       ├── dashboard_screen.dart
│       └── orders_screen.dart
└── utils/
    └── constants.dart
```

## 🔗 API Documentation Links

-   Postman Collection: [Create and import this URL]
-   Swagger/OpenAPI: [Add swagger documentation later]

## 📝 Notes

-   All admin endpoints require `Authorization: Bearer <token>` header
-   Guest endpoints use session cookies for cart
-   All responses are in JSON format
-   Error responses include `message` and `errors` fields

### Images in Flutter

-   Product and cart responses include **`image_url`** (full URL) and `image` (path).
-   Use **`image_url`** for `Image.network()` in Flutter so images load correctly (e.g. `Image.network(product['image_url'] ?? '')`).
-   Handle null: some products may have no image (`image_url` will be `null`).
