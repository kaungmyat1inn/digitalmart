@extends('layouts.admin') {{-- Layout ဖိုင်နာမည် ပြောင်းထားသည် --}}

@section('title', 'Dashboard Overview')

@section('content')
    {{-- Cards Section --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        {{-- Low Stock Products --}}
        <div
            class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center justify-between transition-colors duration-300">
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Low Stock (&le; 5)</p>
                <h3 class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">{{ $lowStockCount }}</h3>
                <p class="text-xs text-yellow-500 mt-1">Check inventory</p>
            </div>
            <div
                class="h-12 w-12 bg-yellow-100 dark:bg-yellow-900 text-yellow-600 dark:text-yellow-300 rounded-lg flex items-center justify-center text-xl">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
        </div>

        {{-- Out of Stock Products --}}
        <div
            class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center justify-between transition-colors duration-300">
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Out of Stock</p>
                <h3 class="text-2xl font-bold text-red-600 dark:text-red-400">{{ $outOfStockCount }}</h3>
                <p class="text-xs text-red-500 mt-1">Restock needed</p>
            </div>
            <div
                class="h-12 w-12 bg-red-100 dark:bg-red-900 text-red-600 dark:text-red-300 rounded-lg flex items-center justify-center text-xl">
                <i class="fas fa-box-open"></i>
            </div>
        </div>

        {{-- Total Sales --}}
        <div
            class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center justify-between transition-colors duration-300">
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Total Sales</p>
                <h3 class="text-2xl font-bold text-gray-800 dark:text-white">
                    {{ number_format($totalSales) }} Ks
                </h3>
                <p class="text-xs text-gray-400 mt-1">All time</p>
            </div>
            <div
                class="h-12 w-12 bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-300 rounded-lg flex items-center justify-center text-xl">
                <i class="fas fa-sack-dollar"></i>
            </div>
        </div>

        {{-- Today Sales --}}
        <div
            class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center justify-between transition-colors duration-300">
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Today Sales</p>
                <h3 class="text-2xl font-bold text-gray-800 dark:text-white">
                    {{ number_format($todaySales) }} Ks
                </h3>
                <p class="text-xs text-green-500 mt-1 flex items-center gap-1">
                    <i class="fas fa-arrow-up"></i> Today's Income
                </p>
            </div>
            <div
                class="h-12 w-12 bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300 rounded-lg flex items-center justify-center text-xl">
                <i class="fas fa-chart-line"></i>
            </div>
        </div>

        {{-- Pending Orders --}}
        <div
            class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center justify-between transition-colors duration-300">
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Pending Orders</p>
                <h3 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $pendingOrders }}</h3>
                <p class="text-xs text-orange-500 mt-1">Needs Attention</p>
            </div>
            <div
                class="h-12 w-12 bg-orange-100 dark:bg-orange-900 text-orange-600 dark:text-orange-300 rounded-lg flex items-center justify-center text-xl">
                <i class="fas fa-clock"></i>
            </div>
        </div>

        {{-- Today Orders --}}
        <div
            class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center justify-between transition-colors duration-300">
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Today Orders</p>
                <h3 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $todayOrders }}</h3>
                <p class="text-xs text-gray-400 mt-1">New orders today</p>
            </div>
            <div
                class="h-12 w-12 bg-purple-100 dark:bg-purple-900 text-purple-600 dark:text-purple-300 rounded-lg flex items-center justify-center text-xl">
                <i class="fas fa-shopping-bag"></i>
            </div>
        </div>
    </div>

    {{-- Recent Orders Table --}}
    <div
        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden transition-colors duration-300">
        <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
            <h3 class="font-bold text-gray-800 dark:text-white">Recent Orders</h3>
            <a href="#" class="text-blue-600 dark:text-blue-400 text-sm hover:underline font-medium">View All
                Orders</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead
                    class="bg-gray-50 dark:bg-gray-700 text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Order ID</th>
                        <th class="px-6 py-4 font-semibold">Customer</th>
                        <th class="px-6 py-4 font-semibold">Status</th>
                        <th class="px-6 py-4 font-semibold">Total</th>
                        <th class="px-6 py-4 font-semibold">Date</th>
                    </tr>
                </thead>

                {{-- ID: recent-orders-body ကို မဖြစ်မနေ ထည့်ရပါမယ် (AJAX အတွက်) --}}
                <tbody id="recent-orders-body"
                    class="divide-y divide-gray-100 dark:divide-gray-700 text-sm text-gray-700 dark:text-gray-300">
                    @forelse($recentOrders as $order)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150">
                            <td class="px-6 py-4 font-bold whitespace-nowrap">
                                <a href="{{ route('admin.orders.details', $order->id) }}"
                                    class="text-blue-600 dark:text-blue-400 hover:underline">
                                    {{ $order->order_number }}
                                </a>
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="font-medium text-gray-900 dark:text-white">{{ $order->customer_name }}</span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">{{ $order->customer_phone }}</span>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                @php
                                    $statusClasses = match ($order->status) {
                                        'pending'
                                        => 'bg-orange-100 text-orange-700 dark:bg-orange-900/50 dark:text-orange-300 border-orange-200 dark:border-orange-800',
                                        'confirmed'
                                        => 'bg-blue-100 text-blue-700 dark:bg-blue-900/50 dark:text-blue-300 border-blue-200 dark:border-blue-800',
                                        'processing'
                                        => 'bg-purple-100 text-purple-700 dark:bg-purple-900/50 dark:text-purple-300 border-purple-200 dark:border-purple-800',
                                        'delivered'
                                        => 'bg-green-100 text-green-700 dark:bg-green-900/50 dark:text-green-300 border-green-200 dark:border-green-800',
                                        'cancelled'
                                        => 'bg-red-100 text-red-700 dark:bg-red-900/50 dark:text-red-300 border-red-200 dark:border-red-800',
                                        default
                                        => 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300 border-gray-200',
                                    };
                                @endphp
                                <span class="px-3 py-1 rounded-full text-xs font-bold border {{ $statusClasses }} capitalize">
                                    {{ $order->status }}
                                </span>
                            </td>

                            <td class="px-6 py-4 font-bold whitespace-nowrap">
                                {{ number_format($order->total_amount) }} Ks
                            </td>

                            <td class="px-6 py-4 text-gray-500 dark:text-gray-400 whitespace-nowrap">
                                {{ $order->created_at->format('d M Y') }}
                                <div class="text-xs">{{ $order->created_at->format('h:i A') }}</div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                No orders found yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection