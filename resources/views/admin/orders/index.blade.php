@extends('layouts.admin')

@section('title', 'All Orders Management')

@section('content')
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">

        <div class="p-6 border-b border-gray-100 dark:border-gray-700">

            {{-- Header Title & Total --}}
            <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
                <div class="flex items-center gap-3">
                    <h3 class="font-bold text-gray-800 dark:text-white text-lg">Order List</h3>
                    <span class="px-3 py-1 bg-blue-100 text-blue-600 rounded-full text-xs font-bold">
                        Total: {{ $orders->total() }}
                    </span>
                </div>

                {{-- Search Form --}}
                <form action="{{ route('admin.orders.index') }}" method="GET" class="w-full md:w-auto">
                    {{-- Status မပျောက်သွားအောင် Hidden Input ထည့်ပေးရသည် --}}
                    <input type="hidden" name="status" value="{{ request('status') }}">

                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>

                        <input type="text" name="search" value="{{ request('search') }}"
                            class="block w-full md:w-64 p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Search ID, Name or Phone...">

                        @if (request('search'))
                            <a href="{{ route('admin.orders.index', ['status' => request('status')]) }}"
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-red-500">
                                <i class="fas fa-times"></i>
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            {{-- Status Filter Tabs (New Added) --}}
            <div class="overflow-x-auto no-scrollbar">
                <div class="flex space-x-2 min-w-max pb-2">
                    @php
                        $currentStatus = request('status') ?? 'all';
                        function getTabClass($status, $current)
                        {
                            $base = "px-4 py-2 rounded-lg text-sm font-bold transition flex items-center gap-2 border ";
                            if ($status == $current) {
                                return $base . "bg-blue-600 text-white border-blue-600 shadow-md";
                            }
                            return $base . "bg-gray-50 text-gray-600 border-gray-200 hover:bg-gray-100 hover:text-blue-600 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600";
                        }
                    @endphp

                    {{-- 1. All --}}
                    <a href="{{ route('admin.orders.index', ['status' => 'all', 'search' => request('search')]) }}"
                        class="{{ getTabClass('all', $currentStatus) }}">
                        All Orders
                        <span
                            class="py-0.5 px-2 rounded-full text-xs ml-1 {{ $currentStatus == 'all' ? 'bg-white text-blue-600' : 'bg-gray-200 text-gray-600' }}">
                            {{ $counts['all'] }}
                        </span>
                    </a>

                    {{-- 2. Pending --}}
                    <a href="{{ route('admin.orders.index', ['status' => 'pending', 'search' => request('search')]) }}"
                        class="{{ getTabClass('pending', $currentStatus) }}">
                        <i class="fas fa-clock text-xs"></i> Pending
                        <span
                            class="py-0.5 px-2 rounded-full text-xs ml-1 {{ $currentStatus == 'pending' ? 'bg-white text-blue-600' : 'bg-gray-200 text-gray-600' }}">
                            {{ $counts['pending'] }}
                        </span>
                    </a>

                    {{-- 3. Purchased --}}
                    <a href="{{ route('admin.orders.index', ['status' => 'purchased', 'search' => request('search')]) }}"
                        class="{{ getTabClass('purchased', $currentStatus) }}">
                        <i class="fas fa-money-bill text-xs"></i> Purchased
                        <span
                            class="py-0.5 px-2 rounded-full text-xs ml-1 {{ $currentStatus == 'purchased' ? 'bg-white text-blue-600' : 'bg-gray-200 text-gray-600' }}">
                            {{ $counts['purchased'] }}
                        </span>
                    </a>

                    {{-- 4. Transporting --}}
                    <a href="{{ route('admin.orders.index', ['status' => 'transporting', 'search' => request('search')]) }}"
                        class="{{ getTabClass('transporting', $currentStatus) }}">
                        <i class="fas fa-truck text-xs"></i> Transporting
                        <span
                            class="py-0.5 px-2 rounded-full text-xs ml-1 {{ $currentStatus == 'transporting' ? 'bg-white text-blue-600' : 'bg-gray-200 text-gray-600' }}">
                            {{ $counts['transporting'] }}
                        </span>
                    </a>

                    {{-- 5. Delivered --}}
                    <a href="{{ route('admin.orders.index', ['status' => 'delivered', 'search' => request('search')]) }}"
                        class="{{ getTabClass('delivered', $currentStatus) }}">
                        <i class="fas fa-check-circle text-xs"></i> Delivered
                        <span
                            class="py-0.5 px-2 rounded-full text-xs ml-1 {{ $currentStatus == 'delivered' ? 'bg-white text-blue-600' : 'bg-gray-200 text-gray-600' }}">
                            {{ $counts['delivered'] }}
                        </span>
                    </a>

                    {{-- 6. Cancelled --}}
                    <a href="{{ route('admin.orders.index', ['status' => 'cancelled', 'search' => request('search')]) }}"
                        class="{{ getTabClass('cancelled', $currentStatus) }}">
                        <i class="fas fa-times-circle text-xs"></i> Cancelled
                        <span
                            class="py-0.5 px-2 rounded-full text-xs ml-1 {{ $currentStatus == 'cancelled' ? 'bg-white text-blue-600' : 'bg-gray-200 text-gray-600' }}">
                            {{ $counts['cancelled'] }}
                        </span>
                    </a>
                </div>
            </div>
        </div>

        {{-- Table Content --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead
                    class="bg-gray-50 dark:bg-gray-700 text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Order ID</th>
                        <th class="px-6 py-4 font-semibold">Customer</th>
                        <th class="px-6 py-4 font-semibold">Status</th>
                        <th class="px-6 py-4 font-semibold">Total Amount</th>
                        <th class="px-6 py-4 font-semibold">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700 text-sm text-gray-700 dark:text-gray-300">
                    @forelse($orders as $order)
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
                                        'pending' => 'bg-orange-100 text-orange-700 dark:bg-orange-900/50 dark:text-orange-300 border-orange-200 dark:border-orange-800',
                                        'purchased' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/50 dark:text-blue-300 border-blue-200 dark:border-blue-800',
                                        'transporting' => 'bg-purple-100 text-purple-700 dark:bg-purple-900/50 dark:text-purple-300 border-purple-200 dark:border-purple-800',
                                        'delivered' => 'bg-green-100 text-green-700 dark:bg-green-900/50 dark:text-green-300 border-green-200 dark:border-green-800',
                                        'cancelled' => 'bg-red-100 text-red-700 dark:bg-red-900/50 dark:text-red-300 border-red-200 dark:border-red-800',
                                        default => 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300 border-gray-200',
                                    };
                                @endphp
                                <span class="px-3 py-1 rounded-full text-xs font-bold border capitalize {{ $statusClasses }}">
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
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fas fa-box-open text-4xl mb-3 text-gray-300"></i>
                                    <p>No orders found yet.</p>
                                    @if(request('status') || request('search'))
                                        <a href="{{ route('admin.orders.index') }}"
                                            class="mt-2 text-blue-600 hover:underline text-sm">Clear Filters</a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-gray-100 dark:border-gray-700">
            {{ $orders->links() }}
        </div>
    </div>
@endsection