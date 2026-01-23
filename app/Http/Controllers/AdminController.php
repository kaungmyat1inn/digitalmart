<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\OrderItem;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        // ၁။ စုစုပေါင်း ရောင်းရငွေ (Total Sales)
        $totalSales = Order::sum('total_amount');

        // ၂။ ဒီနေ့အတွက် ရောင်းရငွေ (Today Sales)
        $todaySales = Order::whereDate('created_at', Carbon::today())->sum('total_amount');

        // ၃။ Pending ဖြစ်နေသော အော်ဒါအရေအတွက်
        $pendingOrders = Order::where('status', 'pending')->count();

        // ၄။ ဒီနေ့ဝင်လာသော အော်ဒါအရေအတွက်
        $todayOrders = Order::whereDate('created_at', Carbon::today())->count();

        // ၅။ လတ်တလော အော်ဒါ ၅ ခု (Recent Orders)
        $recentOrders = Order::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalSales',
            'todaySales',
            'pendingOrders',
            'todayOrders',
            'recentOrders'
        ));
    }

    public function getRecentOrdersHtml()
    {
        $orders = Order::latest()->take(5)->get();
        $html = '';

        foreach ($orders as $order) {
            // Status အသစ်များအတွက် အရောင်သတ်မှတ်ခြင်း
            $statusClasses = match ($order->status) {
                'pending' => 'bg-orange-100 text-orange-700 dark:bg-orange-900/50 dark:text-orange-300 border-orange-200 dark:border-orange-800',
                'purchased' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/50 dark:text-blue-300 border-blue-200 dark:border-blue-800',
                'transporting' => 'bg-purple-100 text-purple-700 dark:bg-purple-900/50 dark:text-purple-300 border-purple-200 dark:border-purple-800',
                'delivered' => 'bg-green-100 text-green-700 dark:bg-green-900/50 dark:text-green-300 border-green-200 dark:border-green-800',
                'cancelled' => 'bg-red-100 text-red-700 dark:bg-red-900/50 dark:text-red-300 border-red-200 dark:border-red-800',
                default => 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300 border-gray-200',
            };

            $html .= '
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150">
                <td class="px-6 py-4 font-bold whitespace-nowrap">
                    <a href="' . route('admin.orders.details', $order->id) . '" class="text-blue-600 dark:text-blue-400 hover:underline">
                        ' . $order->order_number . '
                    </a>
                </td>
                <td class="px-6 py-4">
                    <div class="flex flex-col">
                        <span class="font-medium text-gray-900 dark:text-white">' . $order->customer_name . '</span>
                        <span class="text-xs text-gray-500 dark:text-gray-400">' . $order->customer_phone . '</span>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <span class="px-3 py-1 rounded-full text-xs font-bold border capitalize ' . $statusClasses . '">
                        ' . $order->status . '
                    </span>
                </td>
                <td class="px-6 py-4 font-bold whitespace-nowrap">
                    ' . number_format($order->total_amount) . ' Ks
                </td>
                <td class="px-6 py-4 text-gray-500 dark:text-gray-400 whitespace-nowrap">
                    ' . $order->created_at->format('d M Y') . '
                    <div class="text-xs">' . $order->created_at->format('h:i A') . '</div>
                </td>
            </tr>';
        }

        return response()->json(['html' => $html]);
    }

    // ==========================================
    // UPDATED ORDER INDEX (Status Filter Added)
    // ==========================================
    public function orderIndex()
    {
        // ၁။ Status အလိုက် အရေအတွက်များ (Tabs မှာပြဖို့)
        $counts = [
            'all' => Order::count(),
            'pending' => Order::where('status', 'pending')->count(),
            'purchased' => Order::where('status', 'purchased')->count(),
            'transporting' => Order::where('status', 'transporting')->count(),
            'delivered' => Order::where('status', 'delivered')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
        ];

        // ၂။ Query စဆောက်မယ်
        $query = Order::latest();

        // ၃။ Status Filter စစ်မယ် (URL ?status=pending လို့လာရင်)
        if (request('status') && request('status') != 'all') {
            $query->where('status', request('status'));
        }

        // ၄။ Search Filter စစ်မယ်
        if ($search = request('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%$search%")
                    ->orWhere('customer_name', 'like', "%$search%")
                    ->orWhere('customer_phone', 'like', "%$search%");
            });
        }

        // ၅။ Pagination (Search နဲ့ Status မပျောက်အောင် appends သုံးမယ်)
        $orders = $query->paginate(10)->appends(request()->all());

        return view('admin.orders.index', compact('orders', 'counts'));
    }

    public function orderDetails($id)
    {
        // Relationship ချိတ်ရန် items.product လိုသည်
        $order = Order::with('items.product')->findOrFail($id);
        return view('admin.orders.detail', compact('order'));
    }

    public function updateStatus(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        $order->status = $request->status;
        $order->save();

        return back()->with('success', 'Order status updated successfully!');
    }

    public function editInvoice($id)
    {
        $order = Order::with('items.product')->findOrFail($id);
        return view('admin.invoices.edit', compact('order'));
    }

    public function updateInvoice(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        // ၁။ ဖျက်လိုက်သော ပစ္စည်းများကို Database မှ ဖယ်ရှားခြင်း
        if ($request->has('remove_items')) {
            OrderItem::destroy($request->remove_items);
        }

        // ၂။ ရှိပြီးသား ပစ္စည်းများကို Update လုပ်ခြင်း
        $grandTotal = 0;

        if ($request->has('items')) {
            foreach ($request->items as $itemId => $data) {
                // Remove list ထဲပါသွားတဲ့ ကောင်ဆိုရင် ကျော်သွားမယ်
                if (in_array($itemId, $request->remove_items ?? [])) continue;

                $item = OrderItem::findOrFail($itemId);
                $item->quantity = $data['quantity'];
                $item->price = $data['price'];
                $item->save();

                $grandTotal += ($item->price * $item->quantity);
            }
        }

        // ၃။ အသစ်ထပ်ထည့်သော ပစ္စည်းများကို Create လုပ်ခြင်း
        if ($request->has('new_items')) {
            foreach ($request->new_items as $newItem) {
                $product = Product::find($newItem['product_id']);

                if ($product) {
                    $orderItem = new OrderItem();
                    $orderItem->order_id = $order->id;
                    $orderItem->product_id = $product->id;
                    $orderItem->price = $newItem['price'];
                    $orderItem->quantity = $newItem['quantity'];
                    $orderItem->save();

                    $grandTotal += ($orderItem->price * $orderItem->quantity);
                }
            }
        }

        // ၄။ Customer Info & Grand Total Update
        $order->customer_name = $request->customer_name;
        $order->customer_phone = $request->customer_phone;
        $order->address = $request->address;
        $order->total_amount = $grandTotal;
        $order->save();

        return redirect()->route('admin.orders.details', $id)->with('success', 'Invoice updated successfully!');
    }

    // AJAX Search for Products in Invoice Edit
    public function searchProducts(Request $request)
    {
        $request->validate([
            'query' => 'required|string|max:50',
        ]);

        $query = $request->get('query');

        $products = Product::where('name', 'like', "%{$query}%")
            ->orWhere('code_number', 'like', "%{$query}%")
            ->take(10)
            ->get();

        return response()->json($products);
    }

    // Store new category via AJAX
    public function storeAjax(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:categories,name'
            ]);

            $category = Category::create([
                'name' => $request->name
            ]);

            return response()->json([
                'success' => true,
                'category' => $category,
                'message' => 'Category created successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    // List all categories
    public function indexCategories()
    {
        $categories = Category::withCount('products')->orderBy('name')->get();
        return view('admin.categories.index', compact('categories'));
    }

    // Store new category
    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name'
        ]);

        try {
            Category::create([
                'name' => $request->name
            ]);

            return redirect()->route('admin.categories.index')->with('success', 'Category created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    // Delete category
    public function destroyCategory($id)
    {
        try {
            $category = Category::findOrFail($id);

            if ($category->products()->count() > 0) {
                return redirect()->back()->with('error', 'Cannot delete category with existing products!');
            }

            $category->delete();
            return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
