<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\PromotionSlide;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search', '');

        $slides = PromotionSlide::where('is_active', true)
            ->orderBy('sort_order')
            ->orderByDesc('created_at')
            ->get();

        $products = \App\Models\Product::with(['category', 'variants'])
            ->withCount('orderItems')
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('code_number', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->orderByRaw('CASE WHEN stock > 0 THEN 1 ELSE 0 END DESC')
            ->orderBy('order_items_count', 'desc')
            ->latest()
            ->paginate(16);

        $featuredProductsCount = Product::count();
        $inStockProductsCount = Product::where('stock', '>', 0)->count();
        $totalOrdersCount = Order::count();

        return view('home', compact(
            'products',
            'search',
            'slides',
            'featuredProductsCount',
            'inStockProductsCount',
            'totalOrdersCount'
        ));
    }
    public function trackOrder(Request $request)
    {
        // Search Button နှိပ်မှ အလုပ်လုပ်မယ်
        if ($request->has('order_number') && $request->has('phone')) {

            $orderNumber = $request->order_number;
            $phone = $request->phone;

            // ၁။ ဖုန်းနံပါတ်ကို မြန်မာလိုရိုက်လာရင် အင်္ဂလိပ်လို ပြောင်းမယ် (Database နဲ့ တိုက်စစ်ဖို့)
            $phone = str_replace(
                ['၀', '၁', '၂', '၃', '၄', '၅', '၆', '၇', '၈', '၉'],
                ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'],
                $phone
            );



            $order = Order::where('order_number', $orderNumber)
                ->where('customer_phone', $phone)
                ->with('items.product')
                ->first();

            if (!$order) {
                return redirect()->back()->with('error', 'အော်ဒါနံပါတ် (သို့) ဖုန်းနံပါတ် မှားယွင်းနေပါသည်။');
            }

            // တွေ့ရင် result နဲ့တကွ ပြန်ပြမယ်
            return view('track_order', compact('order'));
        }

        // ဘာမှမနှိပ်ရသေးရင် Form အလွတ်ပြမယ်
        return view('track_order');
    }
}
