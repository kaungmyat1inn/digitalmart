<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;

class CartController extends Controller
{
    /**
     * Get cart contents.
     */
    public function index(Request $request)
    {
        $cart = Session::get('cart', []);

        $cartItems = [];
        $totalAmount = 0;

        foreach ($cart as $id => $item) {
            $product = Product::with('category')->find($id);
            if ($product) {
                $itemTotal = $product->price * $item['quantity'];
                $totalAmount += $itemTotal;

                $cartItems[] = [
                    'id' => $id,
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'code_number' => $product->code_number,
                    'price' => $product->price,
                    'quantity' => $item['quantity'],
                    'image' => $product->image,
                    'image_url' => $product->image_url,
                    'category' => $product->category->name ?? null,
                    'subtotal' => $itemTotal,
                    'stock' => $product->stock,
                ];
            }
        }

        return response()->json([
            'success' => true,
            'data' => [
                'items' => $cartItems,
                'total_amount' => $totalAmount,
                'item_count' => count($cartItems),
            ],
        ]);
    }

    /**
     * Add item to cart.
     */
    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $productId = $request->product_id;
        $quantity = $request->quantity;

        $product = Product::find($productId);
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found',
            ], 404);
        }

        if ($product->stock < $quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient stock. Available: ' . $product->stock,
            ], 400);
        }

        $cart = Session::get('cart', []);

        if (isset($cart[$productId])) {
            $newQuantity = $cart[$productId]['quantity'] + $quantity;
            if ($product->stock < $newQuantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Total quantity exceeds available stock. Available: ' . $product->stock,
                ], 400);
            }
            $cart[$productId]['quantity'] = $newQuantity;
        } else {
            $cart[$productId] = [
                'quantity' => $quantity,
            ];
        }

        Session::put('cart', $cart);

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart',
            'data' => [
                'cart_count' => count($cart),
            ],
        ]);
    }

    /**
     * Update cart item quantity.
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $productId = $request->product_id;
        $quantity = $request->quantity;

        $product = Product::find($productId);
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found',
            ], 404);
        }

        $cart = Session::get('cart', []);

        if (!isset($cart[$productId])) {
            return response()->json([
                'success' => false,
                'message' => 'Product not in cart',
            ], 404);
        }

        if ($quantity === 0) {
            unset($cart[$productId]);
            $message = 'Product removed from cart';
        } elseif ($product->stock < $quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient stock. Available: ' . $product->stock,
            ], 400);
        } else {
            $cart[$productId]['quantity'] = $quantity;
            $message = 'Cart updated';
        }

        Session::put('cart', $cart);

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => [
                'cart_count' => count($cart),
            ],
        ]);
    }

    /**
     * Remove item from cart.
     */
    public function remove(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $productId = $request->product_id;
        $cart = Session::get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            Session::put('cart', $cart);

            return response()->json([
                'success' => true,
                'message' => 'Product removed from cart',
                'data' => [
                    'cart_count' => count($cart),
                ],
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Product not in cart',
        ], 404);
    }

    /**
     * Clear cart.
     */
    public function clear(Request $request)
    {
        Session::forget('cart');

        return response()->json([
            'success' => true,
            'message' => 'Cart cleared',
            'data' => [
                'cart_count' => 0,
            ],
        ]);
    }
}

