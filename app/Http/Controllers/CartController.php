<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    // Cart စာမျက်နှာကို ပြမယ်
    public function index()
    {
        return view('cart');
    }

    public function addToCart($id)
    {
        $product = Product::withTrashed()->find($id);
        if (!$product) {
            if (request()->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Product not found or unavailable.']);
            }
            return redirect()->back()->with('error', 'Product not found or unavailable.');
        }

        $cart = session()->get('cart', []);

        // Cart ထဲမှာ ရှိပြီးသားဆိုရင် အရေအတွက် (Quantity) တိုးမယ်
        if (isset($cart[$id])) {
            $newQty = $cart[$id]['quantity'] + 1;
            if ($newQty > $product->stock) {
                if (request()->expectsJson()) {
                    return response()->json(['success' => false, 'message' => 'Cannot add more than available stock.']);
                }
                return redirect()->back()->with('error', 'Cannot add more than available stock.');
            }
            $cart[$id]['quantity'] = $newQty;
        } else {
            // မရှိသေးရင် အသစ်ထည့်မယ်
            if ($product->stock < 1) {
                if (request()->expectsJson()) {
                    return response()->json(['success' => false, 'message' => 'Product is out of stock.']);
                }
                return redirect()->back()->with('error', 'Product is out of stock.');
            }
            $cart[$id] = [
                "name" => $product->name,
                "code_number" => $product->code_number,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image
            ];
        }

        session()->put('cart', $cart);

        if (request()->expectsJson()) {
            $totalItems = array_sum(array_column($cart, 'quantity'));
            return response()->json([
                'success' => true,
                'message' => 'Product added to cart successfully! 🛒',
                'cart_count' => $totalItems
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Product added to cart successfully!');
    }

    // AJAX: Get cart count
    public function count()
    {
        $cart = session()->get('cart', []);
        $count = array_sum(array_column($cart, 'quantity'));
        return response()->json(['count' => $count, 'success' => true]);
    }

    public function update(Request $request)
    {
        if ($request->id && $request->quantity) {
            $cart = session()->get('cart');
            $product = Product::withTrashed()->find($request->id);
            if (!$product) {
                session()->flash('error', 'Product not found or unavailable.');
                return;
            }
            $newQty = (int) $request->quantity;
            if ($newQty < 1) {
                $newQty = 1;
            }
            if ($newQty > $product->stock) {
                session()->flash('error', 'Cannot set quantity more than available stock.');
                return;
            }
            // Quantity ကို Update လုပ်မယ်
            $cart[$request->id]['quantity'] = $newQty;
            // Session ထဲ ပြန်ထည့်မယ်
            session()->put('cart', $cart);
            session()->flash('success', 'Cart updated successfully');
        }
    }

    // Cart ထဲက ပစ္စည်းဖျက်မယ်
    public function remove(Request $request)
    {
        if ($request->id) {
            $cart = session()->get('cart');
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            session()->flash('success', 'Product removed successfully');
        }
    }

    // Checkout လုပ်မယ်
    public function checkout(Request $request)
    {
        // 1. Validation
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required'
        ]);

        $cart = session()->get('cart');

        if (!$cart) {
            return redirect()->back()->with('error', 'Cart is empty');
        }

        // Transaction စမယ်
        return DB::transaction(function () use ($request, $cart) {
            $totalAmount = 0;
            foreach ($cart as $item) {
                $totalAmount += $item['price'] * $item['quantity'];
            }

            // Order Create
            $order = Order::create([
                'order_number' => 'ORD-' . strtoupper(uniqid()),
                'customer_name' => $request->name,
                'customer_phone' => $request->phone,
                'address' => $request->address,
                'total_amount' => $totalAmount,
                'status' => 'pending',
                'ip_address' => $request->ip(),
            ]);

            // Order Items Create
            foreach ($cart as $id => $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $id,
                    'quantity' => $item['quantity'],
                    'price' => $item['price']
                ]);

                // Reduce product stock
                $product = Product::find($id);
                if ($product) {
                    $product->stock = max(0, $product->stock - $item['quantity']);
                    $product->save();
                }
            }

            // Success Session သိမ်းမယ်
            session()->flash('order_success', [
                'order_number' => $order->order_number,
                'date' => now()->timezone('Asia/Yangon')->format('d/m/Y h:i A'),
                'items' => $cart, // အပေါ်မှာ code_number နဲ့ ပြင်ထားလို့ ဒီမှာ Auto ပါလာပါလိမ့်မယ်
                'name' => $request->name,
                'phone' => $request->phone,
            ]);

            // Cart ရှင်းမယ်
            session()->forget('cart');

            return redirect()->route('cart.index');
        });
    }
}
