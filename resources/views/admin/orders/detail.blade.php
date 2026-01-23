@extends('layouts.admin')

@section('title', 'Order Details')

@section('content')
    <div class="container mx-auto">

        <div class="flex justify-between items-center mb-6 print:hidden">
            <a href="{{ route('admin.dashboard') }}"
                class="inline-flex items-center text-gray-500 hover:text-blue-600 transition">
                <i class="fas fa-arrow-left mr-2"></i> Back to Dashboard
            </a>

            <div class="flex gap-2">
                <button onclick="window.print()"
                    class="bg-gray-700 hover:bg-gray-800 text-white font-bold py-2 px-4 rounded-lg shadow transition flex items-center gap-2">
                    <i class="fas fa-print"></i> Print Invoice
                </button>

                <button id="btn-save-image"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow transition flex items-center gap-2">
                    <i class="fas fa-image"></i> Save as Image
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 print:hidden">
            <div class="lg:col-span-2 space-y-6">
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">

                    <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                        <div class="flex items-center gap-4">
                            <h3 class="font-bold text-gray-800 dark:text-white">Order Items</h3>
                            <span class="text-sm text-gray-500 dark:text-gray-400">Total {{ $order->items->count() }}
                                Items</span>
                        </div>
                        <a href="{{ route('admin.invoice.edit', $order->id) }}"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded-lg shadow transition flex items-center gap-2">
                            <i class="fas fa-edit"></i> Edit Invoice
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-gray-50 dark:bg-gray-700 text-gray-500 dark:text-gray-400 text-xs uppercase">
                                <tr>
                                    <th class="px-6 py-4">Product</th>
                                    <th class="px-6 py-4 text-center">Price</th>
                                    <th class="px-6 py-4 text-center">Qty</th>
                                    <th class="px-6 py-4 text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                @foreach ($order->items as $item)
                                    <tr>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="h-12 w-12 rounded bg-gray-100 dark:bg-gray-700 flex-shrink-0 overflow-hidden">
                                                    @if ($item->product && $item->product->image)
                                                        @if(Str::startsWith($item->product->image, 'http'))
                                                            {{-- http နဲ့စရင် (Demo URL) ဒီတိုင်းပြမယ် --}}
                                                            <img src="{{ $item->product->image }}" class="h-full w-full object-cover">
                                                        @else
                                                            {{-- မဟုတ်ရင် Storage ကနေ ယူမယ် --}}
                                                            <img src="{{ asset('storage/' . $item->product->image) }}" class="h-full w-full object-cover">
                                                        @endif
                                                    @else
                                                        <div class="h-full w-full flex items-center justify-center text-gray-400">
                                                            <i class="fas fa-box"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <p class="font-medium text-gray-800 dark:text-gray-200">
                                                        {{ $item->product->name ?? 'Deleted Product' }}</p>
                                                    <p class="text-xs text-blue-500 font-bold">
                                                        {{ $item->product->code_number ?? '' }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-center text-gray-600 dark:text-gray-300">
                                            {{ number_format($item->price) }}</td>
                                        <td class="px-6 py-4 text-center text-gray-600 dark:text-gray-300">
                                            x{{ $item->quantity }}</td>
                                        <td class="px-6 py-4 text-right font-bold text-gray-800 dark:text-white">
                                            {{ number_format($item->price * $item->quantity) }} Ks</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="p-6 bg-dark dark:bg-gray-750 border-t border-gray-100 dark:border-gray-700 text-right">
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Grand Total</p>
                        <h2 class="text-3xl font-bold text-blue-600 dark:text-blue-400">
                            {{ number_format($order->total_amount) }} Ks</h2>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                    <h3 class="font-bold text-gray-800 dark:text-white mb-4">Order Status</h3>
                    <form action="{{ route('admin.orders.updateStatus') }}" method="POST">
                        @csrf
                        <input type="hidden" name="order_id" value="{{ $order->id }}">

                        <div class="mb-4">
                            <select name="status"
                                class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white text-sm rounded-lg focus:ring-blue-500 block p-2.5">

                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>
                                    Pending (စောင့်ဆိုင်းဆဲ)
                                </option>

                                <option value="purchased" {{ $order->status == 'purchased' ? 'selected' : '' }}>
                                    Purchased (ဝယ်ယူပြီး)
                                </option>

                                <option value="transporting" {{ $order->status == 'transporting' ? 'selected' : '' }}>
                                    Transporting (သယ်ယူပို့ဆောင်နေ)
                                </option>

                                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>
                                    Delivered (ပို့ဆောင်ပြီး)
                                </option>

                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>
                                    Cancelled (ပယ်ဖျက်)
                                </option>

                            </select>
                        </div>

                        <button type="submit"
                            class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 transition">
                            Update Status
                        </button>
                    </form>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                    <h3
                        class="font-bold text-gray-800 dark:text-white mb-4 border-b border-gray-100 dark:border-gray-700 pb-2">
                        Customer Info</h3>
                    <div class="space-y-4">
                        <div>
                            <p class="text-xs text-gray-400 uppercase font-bold">Name</p>
                            <p class="text-gray-800 dark:text-gray-200 font-medium">{{ $order->customer_name }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase font-bold">Phone</p>
                            <p class="text-gray-800 dark:text-gray-200 font-medium tracking-wide"><a
                                    href="tel:{{ $order->customer_phone }}"
                                    class="hover:text-blue-500">{{ $order->customer_phone }}</a></p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase font-bold">Order Date</p>
                            <p class="text-gray-800 dark:text-gray-200">{{ $order->created_at->format('d M Y, h:i A') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase font-bold">Order ID</p>
                            <p class="text-blue-600 dark:text-blue-400 font-bold">#{{ $order->order_number }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                    <h3
                        class="font-bold text-gray-800 dark:text-white mb-4 border-b border-gray-100 dark:border-gray-700 pb-2">
                        Delivery Address</h3>
                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed text-sm">{{ $order->address }}</p>
                </div>
            </div>
        </div>

        {{-- ======================================================== --}}
        {{-- HIDDEN INVOICE TEMPLATE (For Print & Image Save Only) --}}
        {{-- ======================================================== --}}
        <div id="invoice-print-area" class="hidden print:block bg-white p-10 max-w-3xl mx-auto text-black">
            <div class="flex justify-between items-start mb-8 border-b-2 border-gray-800 pb-4">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">INVOICE</h1>
                    <p class="text-gray-600 font-bold">Digital Mart</p>
                    <p class="text-sm text-gray-500">No.123, Tech Street, Yangon</p>
                    <p class="text-sm text-gray-500">Phone: 09-9772793448</p>
                </div>
                <div class="text-right">
                    <p class="text-xl font-bold text-gray-800">#{{ $order->order_number }}</p>
                    <p class="text-sm text-gray-600">Date: {{ $order->created_at->format('d M Y') }}</p>
                </div>
            </div>

            <div class="flex justify-between mb-8">
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase mb-1">Bill To:</p>
                    <h3 class="text-lg font-bold text-gray-900">{{ $order->customer_name }}</h3>
                    <p class="text-gray-600">{{ $order->customer_phone }}</p>
                    <p class="text-gray-600 max-w-xs">{{ $order->address }}</p>
                </div>
            </div>

            <table class="w-full mb-8 border-collapse">
                <thead>
                    <tr class="border-b-2 border-gray-800">
                        <th class="text-left py-3 font-bold text-gray-900 uppercase text-sm">Item</th>
                        <th class="text-center py-3 font-bold text-gray-900 uppercase text-sm">Qty</th>
                        <th class="text-right py-3 font-bold text-gray-900 uppercase text-sm">Price</th>
                        <th class="text-right py-3 font-bold text-gray-900 uppercase text-sm">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->items as $item)
                        <tr class="border-b border-gray-200">
                            <td class="py-4">
                                <p class="font-bold text-gray-800">{{ $item->product->name ?? 'Deleted Product' }}</p>
                                <p class="text-xs text-gray-500 font-bold">{{ $item->product->code_number ?? '' }}</p>
                            </td>
                            <td class="text-center py-4 text-gray-700">{{ $item->quantity }}</td>
                            <td class="text-right py-4 text-gray-700">{{ number_format($item->price) }}</td>
                            <td class="text-right py-4 font-bold text-gray-900">
                                {{ number_format($item->price * $item->quantity) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="flex justify-end">
                <div class="w-64">
                    <div class="flex justify-between py-2 border-t-2 border-gray-800">
                        <span class="font-bold text-xl text-gray-900">Total</span>
                        <span class="font-bold text-xl text-blue-700">{{ number_format($order->total_amount) }} Ks</span>
                    </div>
                </div>
            </div>

            <div class="mt-12 text-center text-sm text-gray-500 border-t pt-4">
                <p>Thank you for your business!</p>
            </div>
        </div>
        {{-- End Invoice Template --}}

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
        document.getElementById('btn-save-image').addEventListener('click', function () {
            const invoiceArea = document.getElementById('invoice-print-area');
            const btn = this;
            const originalText = btn.innerHTML;

            // 1. ဓာတ်ပုံရိုက်ဖို့အတွက် Hidden ဖြစ်နေတာကို ခဏဖော်မယ်
            invoiceArea.classList.remove('hidden');
            btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Saving...';

            html2canvas(invoiceArea, {
                scale: 2, // ပုံကြည်အောင် Scale တင်မယ်
                backgroundColor: "#ffffff",
                logging: false
            }).then(canvas => {
                // 2. Download Link ဖန်တီးမယ်
                let link = document.createElement('a');
                link.download = 'Invoice-{{ $order->order_number }}.png';
                link.href = canvas.toDataURL("image/png");
                link.click();

                // 3. ပြီးရင် ပြန်ဖျောက်မယ်
                invoiceArea.classList.add('hidden');
                btn.innerHTML = originalText;
            });
        });
    </script>

    {{-- Print Style Override --}}
    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            #invoice-print-area,
            #invoice-print-area * {
                visibility: visible;
            }

            #invoice-print-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                display: block !important;
                margin: 0;
                padding: 20px;
            }

            /* Hide URL headers/footers in some browsers */
            @page {
                size: auto;
                margin: 0mm;
            }
        }
    </style>
@endsection