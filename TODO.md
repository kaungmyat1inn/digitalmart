# Flutter App Implementation Plan

## Updated: Using Riverpod for State Management

### 1. Dependencies (pubspec.yaml)

- `http` - API calls
- `flutter_riverpod` - State management
- `shared_preferences` - Session persistence
- `fluttertoast` - Notifications
- `badges` - Cart badge
- `uuid` - Generate unique IDs

### 2. Project Structure

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

## Implementation Steps

### Step 1: Add dependencies and update pubspec.yaml

### Step 2: Create models (product, category, cart_item, order)

### Step 3: Create constants.dart with API base URL

### Step 4: Create api_service.dart for HTTP calls

### Step 5: Create Riverpod providers (products, cart, categories)

### Step 6: Create widgets (product_card, cart_item_widget)

### Step 7: Create screens (home, product_detail, cart, checkout, order_tracking)

### Step 8: Update main.dart with app structure

## API Endpoints to Use

- GET `/api/products?page=&search=&category=`
- GET `/api/products/{id}`
- GET `/api/categories`
- GET `/api/categories/{id}`
- GET `/api/cart`
- POST `/api/cart/add`
- PUT `/api/cart/update`
- DELETE `/api/cart/remove`
- DELETE `/api/cart/clear`
- POST `/api/orders`
- GET `/api/orders/track?order_number=&phone=`

## Progress

- [x] Step 1: Update pubspec.yaml
- [x] Step 2: Create models (product, category, cart_item, order)
- [x] Step 3: Create constants.dart
- [x] Step 4: Create api_service.dart
- [x] Step 5: Create Riverpod providers
- [x] Step 6: Create widgets
- [x] Step 7: Create screens
- [x] Step 8: Update main.dart
- [x] Step 9: Fix all analysis errors
