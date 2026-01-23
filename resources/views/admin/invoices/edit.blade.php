@extends('layouts.admin')

@section('title', 'Edit Invoice Details')

@section('content')
    <div class="container mx-auto max-w-6xl">

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Edit Invoice #{{ $order->order_number }}</h2>
            <a href="{{ route('admin.orders.details', $order->id) }}" class="text-gray-500 hover:text-blue-600">
                Cancel
            </a>
        </div>

        <form action="{{ route('admin.invoice.update', $order->id) }}" method="POST" id="invoice-form">
            @csrf
            @method('PUT')

            <div id="removed-items-container"></div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <div class="lg:col-span-2 space-y-6">
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-100 dark:border-gray-700">

                        <div class="flex justify-between items-center mb-4">
                            <h3 class="font-bold text-gray-800 dark:text-white">Order Items</h3>
                        </div>

                        <div class="overflow-x-auto mb-6">
                            <table class="w-full text-left" id="items-table">
                                <thead
                                    class="bg-gray-50 dark:bg-gray-700 text-gray-500 dark:text-gray-400 text-xs uppercase">
                                    <tr>
                                        <th class="px-4 py-3">Product</th>
                                        <th class="px-4 py-3 text-center">Price</th>
                                        <th class="px-4 py-3 text-center">Qty</th>
                                        <th class="px-4 py-3 text-right">Total</th>
                                        <th class="px-4 py-3 text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 dark:divide-gray-700" id="items-tbody">
                                    {{-- Existing Items --}}
                                    @foreach($order->items as $item)
                                        <tr class="item-row" data-id="{{ $item->id }}">
                                            <td class="px-4 py-3">
                                                {{-- Product Name --}}
                                                <p class="font-medium text-gray-800 dark:text-gray-200">
                                                    {{ $item->product->name ?? 'Deleted Product' }}
                                                </p>
                                                {{-- Code Number ထည့်လိုက်ပါပြီ --}}
                                                <p class="text-xs text-blue-500 font-bold">
                                                    {{ $item->product->code_number ?? '' }}
                                                </p>
                                            </td>

                                            <td class="px-4 py-3">
                                                <input type="number" name="items[{{ $item->id }}][price]"
                                                    value="{{ $item->price }}"
                                                    class="price-input w-24 text-center bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded p-1 text-sm dark:text-white focus:ring-blue-500">
                                            </td>

                                            <td class="px-4 py-3 text-center">
                                                <input type="number" name="items[{{ $item->id }}][quantity]"
                                                    value="{{ $item->quantity }}" min="1"
                                                    class="qty-input w-16 text-center bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded p-1 text-sm dark:text-white focus:ring-blue-500">
                                            </td>

                                            <td class="px-4 py-3 text-right font-bold text-gray-800 dark:text-white row-total">
                                                {{ number_format($item->price * $item->quantity) }}
                                            </td>

                                            <td class="px-4 py-3 text-center">
                                                <button type="button" onclick="removeExistingItem(this, {{ $item->id }})"
                                                    class="text-red-500 hover:text-red-700 p-2">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div
                            class="p-4 bg-blue-50 dark:bg-gray-700 rounded-lg border border-blue-100 dark:border-gray-600 relative">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Add New
                                Product</label>

                            <div class="relative">
                                <div class="flex gap-2">
                                    <div class="relative w-full">
                                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                            <i class="fas fa-search text-gray-400"></i>
                                        </span>
                                        <input type="text" id="product-search"
                                            class="w-full pl-10 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-900 text-sm rounded-lg focus:ring-blue-500 p-2.5 dark:text-white"
                                            placeholder="Type product name or code (e.g. PRO-123)..." autocomplete="off">

                                        <div id="search-loading"
                                            class="absolute inset-y-0 right-0 flex items-center pr-3 hidden">
                                            <i class="fas fa-circle-notch fa-spin text-blue-500"></i>
                                        </div>
                                    </div>
                                </div>

                                <div id="search-results"
                                    class="absolute z-50 w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-lg shadow-lg mt-1 max-h-60 overflow-y-auto hidden">
                                </div>
                            </div>
                        </div>

                        {{-- Grand Total Display --}}
                        <div class="mt-6 text-right border-t border-gray-100 dark:border-gray-700 pt-4">
                            <span class="text-gray-500 dark:text-gray-400 mr-4">Grand Total:</span>
                            <span id="grand-total" class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                                {{ number_format($order->total_amount) }} Ks
                            </span>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-100 dark:border-gray-700">
                        <h3 class="font-bold text-gray-800 dark:text-white mb-4">Customer Info</h3>

                        <div class="space-y-4">
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                                <input type="text" name="customer_name" value="{{ $order->customer_name }}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Phone</label>
                                <input type="text" name="customer_phone" value="{{ $order->customer_phone }}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Address</label>
                                <textarea name="address" rows="4" autocomplete="off"
                                    class="bg-gray-50 border borday-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ $order->address }}</textarea>
                            </div>
                        </div>

                        <button type="submit"
                            class="w-full mt-6 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                            <i class="fas fa-save mr-2"></i> Save Changes
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        let newItemIndex = 0;

        // 1. Calculate Totals (ပုံမှန်အတိုင်း)
        function updateTotals() {
            let grandTotal = 0;
            const rows = document.querySelectorAll('.item-row');
            rows.forEach(row => {
                if (row.style.display === 'none') return;
                const price = parseFloat(row.querySelector('.price-input').value) || 0;
                const qty = parseInt(row.querySelector('.qty-input').value) || 0;
                const total = price * qty;
                row.querySelector('.row-total').textContent = new Intl.NumberFormat().format(total);
                grandTotal += total;
            });
            document.getElementById('grand-total').textContent = new Intl.NumberFormat().format(grandTotal) + ' Ks';
        }

        // 2. Remove Functions (ပုံမှန်အတိုင်း)
        function removeExistingItem(button, itemId) {
            if (!confirm('Remove this item?')) return;
            button.closest('tr').style.display = 'none';
            const container = document.getElementById('removed-items-container');
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'remove_items[]';
            input.value = itemId;
            container.appendChild(input);
            updateTotals();
        }

        function removeNewItem(button) {
            button.closest('tr').remove();
            updateTotals();
        }

        // ==========================================
        // 3. AJAX Search Logic (New)
        // ==========================================
        const searchInput = document.getElementById('product-search');
        const resultsBox = document.getElementById('search-results');
        const loadingIcon = document.getElementById('search-loading');
        let timeout = null;

        searchInput.addEventListener('input', function () {
            clearTimeout(timeout);
            const query = this.value.trim();

            if (query.length < 1) {
                resultsBox.classList.add('hidden');
                return;
            }

            // Debounce (စာရိုက်ပြီး 300ms နေမှ ရှာမယ်)
            timeout = setTimeout(() => {
                loadingIcon.classList.remove('hidden');

                fetch(`{{ route('admin.products.search') }}?query=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        loadingIcon.classList.add('hidden');
                        resultsBox.innerHTML = '';

                        if (data.length > 0) {
                            resultsBox.classList.remove('hidden');
                            data.forEach(product => {
                                const item = document.createElement('div');
                                item.className = 'p-3 hover:bg-blue-50 dark:hover:bg-gray-700 cursor-pointer border-b border-gray-100 dark:border-gray-700 transition last:border-0';
                                item.innerHTML = `
                                                <div class="flex justify-between items-center">
                                                    <div>
                                                        <p class="font-medium text-gray-800 dark:text-white">${product.name}</p>
                                                        <p class="text-xs text-blue-500 font-bold">${product.code_number ?? ''}</p>
                                                    </div>
                                                    <span class="text-sm font-bold text-gray-600 dark:text-gray-300">
                                                        ${new Intl.NumberFormat().format(product.price)} Ks
                                                    </span>
                                                </div>
                                            `;

                                // Click နှိပ်ရင် ဇယားထဲထည့်မယ်
                                item.onclick = () => {
                                    addItemToTable(product);
                                    resultsBox.classList.add('hidden');
                                    searchInput.value = ''; // Input ရှင်းမယ်
                                };

                                resultsBox.appendChild(item);
                            });
                        } else {
                            resultsBox.innerHTML = '<div class="p-3 text-sm text-gray-500 text-center">No products found</div>';
                            resultsBox.classList.remove('hidden');
                        }
                    });
            }, 300);
        });

        // အပြင်ဘက်နှိပ်ရင် ပိတ်မယ်
        document.addEventListener('click', function (e) {
            if (!searchInput.contains(e.target) && !resultsBox.contains(e.target)) {
                resultsBox.classList.add('hidden');
            }
        });

        // 4. Add Item To Table (Modified)
        function addItemToTable(product) {
            const tbody = document.getElementById('items-tbody');
            const tr = document.createElement('tr');
            tr.className = 'item-row bg-blue-50 dark:bg-gray-700/50';

            tr.innerHTML = `
                            <td class="px-4 py-3">
                                <p class="font-medium text-gray-800 dark:text-gray-200">
                                    ${product.name} <span class="text-xs text-blue-600 font-bold">(New)</span>
                                </p>
                                <p class="text-xs text-blue-500 font-bold">${product.code_number ?? ''}</p>
                                <input type="hidden" name="new_items[${newItemIndex}][product_id]" value="${product.id}">
                            </td>
                            <td class="px-4 py-3">
                                <input type="number" name="new_items[${newItemIndex}][price]" value="${product.price}" class="price-input w-24 text-center bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-500 rounded p-1 text-sm dark:text-white" oninput="updateTotals()">
                            </td>
                            <td class="px-4 py-3 text-center">
                                <input type="number" name="new_items[${newItemIndex}][quantity]" value="1" min="1" class="qty-input w-16 text-center bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-500 rounded p-1 text-sm dark:text-white" oninput="updateTotals()">
                            </td>
                            <td class="px-4 py-3 text-right font-bold text-gray-800 dark:text-white row-total">
                                ${new Intl.NumberFormat().format(product.price)}
                            </td>
                            <td class="px-4 py-3 text-center">
                                <button type="button" onclick="removeNewItem(this)" class="text-red-500 hover:text-red-700 p-2">
                                    <i class="fas fa-times"></i>
                                </button>
                            </td>
                        `;

            tbody.appendChild(tr);
            newItemIndex++;
            updateTotals();
        }

        // Initial Bind
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.price-input, .qty-input').forEach(input => {
                input.addEventListener('input', updateTotals);
            });
        });
    </script>
@endsection