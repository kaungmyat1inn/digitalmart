<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;

// ============ PUBLIC ROUTES ============
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('cart', [CartController::class, 'index'])->name('cart.index');
Route::get('add-to-cart/{id}', [CartController::class, 'addToCart'])->name('add_to_cart');
Route::delete('remove-from-cart', [CartController::class, 'remove'])->name('remove_from_cart');
Route::post('checkout', [CartController::class, 'checkout'])->name('checkout')->middleware('spam.protect');
Route::patch('update-cart', [CartController::class, 'update'])->name('update_cart');
Route::get('/track-order', [HomeController::class, 'trackOrder'])->name('track_order');

// ============ ADMIN LOGIN/LOGOUT ============
Route::get('/admin/login', function () {
        return view('admin.login');
})->name('admin.login')->middleware('guest');

Route::post('/admin/login', function (\Illuminate\Http\Request $request) {
        $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
        ]);

        if (\Illuminate\Support\Facades\Auth::attempt($credentials)) {
                $request->session()->regenerate();
                return redirect()->route('admin.dashboard')->with('success', 'Logged in successfully!');
        }

        return back()->withErrors([
                'email' => 'Invalid credentials.',
        ])->onlyInput('email');
})->middleware('guest')->name('admin.login.post');

Route::post('/admin/logout', function (\Illuminate\Http\Request $request) {
        \Illuminate\Support\Facades\Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login')->with('success', 'Logged out successfully!');
})->middleware('auth')->name('admin.logout');

// ============ PROTECTED ADMIN ROUTES ============
Route::middleware('auth')->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/admin/pending-orders-count', function () {
                $count = App\Models\Order::where('status', 'pending')->count();
                return response()->json(['count' => $count]);
        })->name('admin.pending.count');
        Route::get('/admin/recent-orders-partial', [AdminController::class, 'getRecentOrdersHtml'])->name('admin.recent.orders');

        // Order Management Routes
        Route::get('/admin/orders/{id}', [AdminController::class, 'orderDetails'])->name('admin.orders.details');
        Route::post('/admin/orders/update-status', [AdminController::class, 'updateStatus'])->name('admin.orders.updateStatus');
        Route::get('/admin/orders', [AdminController::class, 'orderIndex'])->name('admin.orders.index');

        // Invoice Management
        Route::get('/admin/orders/{id}/invoice/edit', [AdminController::class, 'editInvoice'])->name('admin.invoice.edit');
        Route::put('/admin/orders/{id}/invoice/update', [AdminController::class, 'updateInvoice'])->name('admin.invoice.update');

        // Product Routes
        Route::get('/admin/products/search', [AdminController::class, 'searchProducts'])->middleware('throttle:60,1')->name('admin.products.search');
        Route::get('/admin/products/generate-code', [ProductController::class, 'generateCode'])->middleware('throttle:60,1')->name('admin.products.generateCode');
        Route::get('/admin/products', [ProductController::class, 'index'])->name('admin.products.index');
        Route::get('/admin/products/create', [ProductController::class, 'create'])->name('admin.products.create');
        Route::post('/admin/products', [ProductController::class, 'store'])->name('admin.products.store');
        Route::get('/admin/products/{id}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
        Route::put('/admin/products/{id}', [ProductController::class, 'update'])->name('admin.products.update');
        Route::delete('/admin/products/{id}', [ProductController::class, 'destroy'])->name('admin.products.destroy');

        // Category Routes
        Route::post('/admin/categories/store-ajax', [AdminController::class, 'storeAjax'])->middleware('throttle:30,1')->name('admin.categories.storeAjax');
        Route::get('/admin/categories', [AdminController::class, 'indexCategories'])->name('admin.categories.index');
        Route::post('/admin/categories', [AdminController::class, 'storeCategory'])->name('admin.categories.store');
        Route::delete('/admin/categories/{id}', [AdminController::class, 'destroyCategory'])->name('admin.categories.destroy');

        // Admin Management Routes (Only for Super Admin)
        Route::middleware('admin.super_admin')->group(function () {
                Route::resource('admin/users', UserController::class, ['as' => 'admin']);
                Route::post('/admin/users/{user}/restore', [UserController::class, 'restore'])->name('admin.users.restore');
                Route::post('/admin/users/{user}/change-role', [UserController::class, 'changeRole'])->name('admin.users.changeRole');
                Route::post('/admin/users/{user}/extend-subscription', [UserController::class, 'extendSubscription'])->name('admin.users.extendSubscription');
                Route::post('/admin/users/{user}/change-password', [UserController::class, 'changePassword'])->name('admin.users.changePassword');
        });
});
