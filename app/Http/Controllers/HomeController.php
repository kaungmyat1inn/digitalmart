<?php

namespace App\Http\Controllers;

use App\Models\Order;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Category နဲ့တွဲပြီး Available ဖြစ်တာတွေပဲ ယူမယ်
        $products = \App\Models\Product::with(['category', 'variants' => function ($q) {
            $q->with('category');
        }])
            ->where('stock', '>', 0)
            ->latest()
            ->get();

        return view('home', compact('products'));
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
