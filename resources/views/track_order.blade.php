@extends('layouts.master')

@section('content')
    <div class="container mx-auto px-4 py-10 min-h-screen">

        <div class="max-w-xl mx-auto">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-8">Track Your Order</h2>

            <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 mb-8">
                <form action="{{ route('track_order') }}" method="GET">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Order No(အော်ဒါနံပါတ်)</label>
                            <input type="text" name="order_number" value="{{ request('order_number') }}" required
                                autocomplete="off" placeholder="Order Number"
                                class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number (ဖုန်းနံပါတ်)</label>
                            <input type="text" name="phone" value="{{ request('phone') }}" required
                                placeholder="09xxxxxxxxx"
                                class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <button type="submit"
                            class="w-full bg-blue-600 text-white py-3 rounded-lg font-bold hover:bg-blue-700 transition">
                            Check Status
                        </button>
                    </div>
                </form>

                @if (session('error'))
                    <div class="mt-4 p-3 bg-red-100 text-red-700 rounded-lg text-sm text-center">
                        {{ session('error') }}
                    </div>
                @endif
            </div>

            @if (isset($order))
                <div class="bg-white rounded-xl shadow-xl overflow-hidden animate-[fadeIn_0.5s_ease-out]">

                    <div class="bg-gray-50 p-6 border-b border-gray-200 flex justify-between items-center">
                        <div>
                            <p class="text-sm text-gray-500">Order ID</p>
                            <p class="text-lg font-bold text-blue-600">{{ $order->order_number }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-500">Date</p>
                            <p class="font-medium text-gray-800">{{ $order->created_at->format('d M Y') }}</p>
                        </div>
                    </div>

                    <div class="p-8">
                        <div class="relative">
                            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-full h-1 bg-gray-200 -z-10"></div>

                            @php
                                $status = $order->status;
                                // Status အသစ်များအတိုင်း ပြင်ဆင်ထားပါသည်
                                $steps = ['pending', 'purchased', 'transporting', 'delivered'];
                                $currentIndex = array_search($status, $steps);

                                // Cancel ဖြစ်သွားရင် Step အကုန်မီးခိုးရောင်ပြမယ်
                                if ($status == 'cancelled') {
                                    $currentIndex = -1;
                                }
                            @endphp

                            <div class="flex justify-between w-full">

                                {{-- Step 1: Pending --}}
                                <div class="flex flex-col items-center gap-2 bg-white px-2">
                                    <div
                                        class="w-10 h-10 rounded-full flex items-center justify-center border-2 {{ $currentIndex >= 0 ? 'bg-green-500 border-green-500 text-white' : 'bg-white border-gray-300 text-gray-400' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <p
                                        class="text-xs font-bold text-center {{ $currentIndex >= 0 ? 'text-green-600' : 'text-gray-400' }}">
                                        Pending<br><span class="text-[10px] font-normal">စောင့်ဆိုင်းဆဲ</span>
                                    </p>
                                </div>

                                {{-- Step 2: Purchased (Confirmed -> Purchased) --}}
                                <div class="flex flex-col items-center gap-2 bg-white px-2">
                                    <div
                                        class="w-10 h-10 rounded-full flex items-center justify-center border-2 {{ $currentIndex >= 1 ? 'bg-green-500 border-green-500 text-white' : 'bg-white border-gray-300 text-gray-400' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                        </svg>
                                    </div>
                                    <p
                                        class="text-xs font-bold text-center {{ $currentIndex >= 1 ? 'text-green-600' : 'text-gray-400' }}">
                                        Purchased<br><span class="text-[10px] font-normal">ဝယ်ယူပြီး</span>
                                    </p>
                                </div>

                                {{-- Step 3: Transporting (Processing -> Transporting) --}}
                                <div class="flex flex-col items-center gap-2 bg-white px-2">
                                    <div
                                        class="w-10 h-10 rounded-full flex items-center justify-center border-2 {{ $currentIndex >= 2 ? 'bg-green-500 border-green-500 text-white' : 'bg-white border-gray-300 text-gray-400' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" stroke-width="2">
                                            <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                                        </svg>
                                    </div>
                                    <p
                                        class="text-xs font-bold text-center {{ $currentIndex >= 2 ? 'text-green-600' : 'text-gray-400' }}">
                                        Transporting<br><span class="text-[10px] font-normal">ပို့ဆောင်နေ</span>
                                    </p>
                                </div>

                                {{-- Step 4: Delivered --}}
                                <div class="flex flex-col items-center gap-2 bg-white px-2">
                                    <div
                                        class="w-10 h-10 rounded-full flex items-center justify-center border-2 {{ $currentIndex >= 3 ? 'bg-green-500 border-green-500 text-white' : 'bg-white border-gray-300 text-gray-400' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                        </svg>
                                    </div>
                                    <p
                                        class="text-xs font-bold text-center {{ $currentIndex >= 3 ? 'text-green-600' : 'text-gray-400' }}">
                                        Delivered<br><span class="text-[10px] font-normal">ရောက်ရှိ</span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Cancelled Alert --}}
                        @if ($status == 'cancelled')
                            <div class="mt-6 bg-red-50 border border-red-100 text-red-700 p-4 rounded-lg text-center">
                                <i class="fas fa-times-circle text-xl mb-2 block"></i>
                                <span class="font-bold">ဤအော်ဒါမှာ ပယ်ဖျက်လိုက်ပါပြီ (Order Cancelled)</span>
                            </div>
                        @endif
                    </div>

                    <div class="p-6 border-t border-gray-100 bg-gray-50">
                        <h4 class="font-bold text-gray-700 mb-4">Order Details</h4>
                        <div class="space-y-3">
                            @foreach ($order->items as $item)
                                <div class="flex justify-between items-start text-sm">
                                    <div class="flex items-start gap-3">
                                        {{-- Product Image Thumbnail (Optional) --}}
                                        <div class="h-12 w-12 rounded bg-gray-100 dark:bg-gray-700 flex-shrink-0 overflow-hidden">
                                            @if ($item->product && $item->product->image)
                                                @if(Str::startsWith($item->product->image, 'http'))
                                                    {{-- http နဲ့စရင် (Demo URL) ဒီတိုင်းပြမယ် --}}
                                                    <img src="{{ $item->product->image }}" class="h-full w-full object-cover">
                                                @else
                                                    {{-- မဟုတ်ရင် Storage ကနေ ယူမယ် --}}
                                                    <img src="{{ asset('storage/' . $item->product->image) }}"
                                                        class="h-full w-full object-cover">
                                                @endif
                                            @else
                                                <div class="h-full w-full flex items-center justify-center text-gray-400">
                                                    <i class="fas fa-box"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="text-gray-800 font-medium">
                                                {{ $item->product ? $item->product->name : 'Unknown Item' }}
                                            </p>
                                            @if(isset($item->product->code_number))
                                                <p class="text-xs text-blue-500 font-bold">{{ $item->product->code_number }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-medium">{{ number_format($item->price * $item->quantity) }} Ks</p>
                                        <p class="text-xs text-gray-500">Qty: {{ $item->quantity }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="border-t border-gray-200 mt-4 pt-4 flex justify-between items-center">
                            <span class="font-bold text-gray-800">Total Amount</span>
                            <span class="font-bold text-blue-600 text-lg">{{ number_format($order->total_amount) }} Ks</span>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
@endsection