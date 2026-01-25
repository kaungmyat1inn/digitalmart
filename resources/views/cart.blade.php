@extends('layouts.master')

@section('content')
    <div class="container mx-auto px-4 py-10">
        <h2 class="text-3xl font-bold mb-6 text-gray-800">Your Shopping Cart</h2>

        @if (session('cart') && count(session('cart')) > 0)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <!-- Desktop Table -->
                <div class="hidden sm:block">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-100 text-gray-600 uppercase text-sm">
                            <tr>
                                <th class="py-4 px-6">Product</th>
                                <th class="py-4 px-6">Price</th>
                                <th class="py-4 px-6 text-center">Quantity</th>
                                <th class="py-4 px-6 text-right">Subtotal</th>
                                <th class="py-4 px-6 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @php $total = 0 @endphp
                            @foreach (session('cart') as $id => $details)
                                @php $total += $details['price'] * $details['quantity'] @endphp
                                <tr class="border-b border-gray-100 hover:bg-gray-50">
                                    <td class="py-4 px-6 flex items-center gap-4">
                                        <img src="{{ Str::startsWith($details['image'], 'http') ? $details['image'] : asset('storage/' . $details['image']) }}"
                                            alt="{{ $details['name'] }}" class="w-16 h-16 object-cover rounded">
                                        <div>
                                            <p class="font-bold">{{ $details['name'] }}</p>
                                            <p class="text-xs text-blue-500 font-bold">{{ $details['code_number'] ?? '' }}
                                            </p>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6">{{ number_format($details['price']) }} Ks</td>
                                    <td class="py-4 px-6">
                                        <div class="flex items-center justify-center">
                                            <button
                                                class="update-cart-qty px-3 py-1 bg-gray-200 text-gray-600 hover:bg-gray-300 rounded-l transition"
                                                data-id="{{ $id }}" data-action="decrease">-</button>
                                            <input type="text" readonly
                                                class="w-12 text-center bg-gray-50 border-t border-b border-gray-200 py-1 qty-input-{{ $id }}"
                                                value="{{ $details['quantity'] }}">
                                            <button
                                                class="update-cart-qty px-3 py-1 bg-gray-200 text-gray-600 hover:bg-gray-300 rounded-r transition"
                                                data-id="{{ $id }}" data-action="increase">+</button>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 text-right font-bold">
                                        {{ number_format($details['price'] * $details['quantity']) }} Ks
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <button class="text-red-500 hover:text-red-700 remove-from-cart" data-id="{{ $id }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Cards -->
                <div class="sm:hidden">
                    @php $total = 0 @endphp
                    @foreach (session('cart') as $id => $details)
                        @php $total += $details['price'] * $details['quantity'] @endphp
                        <div class="p-4 border-b border-gray-200">
                            <div class="flex items-start gap-4">
                                <img src="{{ Str::startsWith($details['image'], 'http') ? $details['image'] : asset('storage/' . $details['image']) }}"
                                    alt="{{ $details['name'] }}" class="w-20 h-20 object-cover rounded-lg">
                                <div class="flex-grow">
                                    <p class="font-bold text-gray-800">{{ $details['name'] }}</p>
                                    <p class="text-xs text-blue-500 font-bold mb-2">{{ $details['code_number'] ?? '' }}
                                    </p>
                                    <p class="text-sm text-gray-600">{{ number_format($details['price']) }} Ks</p>
                                </div>
                                <button class="text-red-500 hover:text-red-700 remove-from-cart" data-id="{{ $id }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                            <div class="flex items-center justify-between mt-4">
                                <div class="flex items-center">
                                    <button
                                        class="update-cart-qty px-3 py-1 bg-gray-200 text-gray-600 hover:bg-gray-300 rounded-l transition"
                                        data-id="{{ $id }}" data-action="decrease">-</button>
                                    <input type="text" readonly
                                        class="w-12 text-center bg-gray-50 border-t border-b border-gray-200 py-1 qty-input-{{ $id }}"
                                        value="{{ $details['quantity'] }}">
                                    <button
                                        class="update-cart-qty px-3 py-1 bg-gray-200 text-gray-600 hover:bg-gray-300 rounded-r transition"
                                        data-id="{{ $id }}" data-action="increase">+</button>
                                </div>
                                <p class="font-bold text-gray-800">
                                    {{ number_format($details['price'] * $details['quantity']) }} Ks
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="p-6 bg-gray-50 flex flex-col sm:flex-row justify-between items-center">
                    <a href="{{ route('home') }}" class="text-blue-600 hover:underline font-medium mb-4 sm:mb-0">
                        &larr; Continue Shopping
                    </a>

                    <div class="text-right">
                        <p class="text-lg font-medium text-gray-600">Total: <span
                                class="text-2xl font-bold text-gray-900">{{ number_format($total) }} Ks</span></p>

                        <button onclick="document.getElementById('checkoutModal').classList.remove('hidden')"
                            class="mt-4 inline-block bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition shadow-lg font-bold">
                            Checkout Order
                        </button>

                        <p class="text-xs text-red-500 mt-3 italic font-medium">
                            * ဈေးနှုန်းများမှာ အပြောင်းအလဲရှိနိုင်ပါသည်
                        </p>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-20 bg-white rounded-lg shadow">
                <h3 class="text-xl font-medium text-gray-500">Your cart is empty!</h3>
                <a href="{{ route('home') }}" class="mt-4 inline-block text-blue-600 hover:underline">Go Shop Now</a>
            </div>
        @endif
    </div>

    {{-- Checkout Modal --}}
    <div id="checkoutModal"
        class="fixed inset-0 bg-gray-900 bg-opacity-60 hidden flex items-center justify-center z-50 backdrop-blur-sm transition-opacity">
        <div class="bg-white rounded-2xl shadow-2xl p-8 max-w-lg w-full mx-4 relative animate-[fadeIn_0.3s_ease-out]">

            <button onclick="document.getElementById('checkoutModal').classList.add('hidden')"
                class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <h3 class="text-2xl font-bold text-gray-900 mb-6 border-b pb-2">Shipping Information</h3>

            <form action="{{ route('checkout') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Name (အမည်)</label>
                        <input type="text" name="name" required
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2.5 bg-gray-50"
                            placeholder="Mg Mg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Phone (ဖုန်းနံပါတ်)</label>
                        <input type="tel" name="phone" id="phoneInput" required inputmode="numeric"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2.5 bg-gray-50"
                            placeholder="09xxxxxxxxx">
                        <p class="text-xs text-gray-400 mt-1">အင်္ဂလိပ် (သို့) မြန်မာဂဏန်း ရိုက်ထည့်နိုင်ပါသည်</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Address (လိပ်စာ)</label>
                        <textarea name="address" required rows="3"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2.5 bg-gray-50"
                            placeholder="No. 123, Bogyoke Road, Yangon"></textarea>
                    </div>
                </div>

                <div class="mt-8 flex gap-3">
                    <button type="button" onclick="document.getElementById('checkoutModal').classList.add('hidden')"
                        class="w-1/3 bg-gray-200 text-gray-700 py-3 rounded-xl font-bold hover:bg-gray-300 transition">
                        Cancel
                    </button>
                    <button type="submit"
                        class="w-2/3 bg-blue-600 text-white py-3 rounded-xl font-bold hover:bg-blue-700 transition shadow-lg">
                        Confirm Order
                    </button>
                </div>
            </form>
        </div>
    </div>


    {{-- Order Success Modal --}}
    @if (session('order_success'))
        <div
            class="fixed inset-0 bg-gray-900 bg-opacity-80 flex items-center justify-center z-[60] backdrop-blur-sm overflow-y-auto">
            <div class="relative w-full max-w-sm mx-4 my-10">

                <button onclick="this.closest('.fixed').remove()"
                    class="absolute -top-10 right-0 text-white hover:text-gray-200">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-8 h-8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <div id="receipt-content" class="bg-white rounded-t-2xl rounded-b-xl shadow-2xl overflow-hidden relative">

                    <div class="h-2 bg-green-500 w-full"></div>

                    <div class="p-6">
                        <div class="text-center mb-6">
                            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-3">
                                <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900">အော်ဒါတင်ခြင်း အောင်မြင်ပါသည်</h3>
                            <p class="text-sm text-gray-500 mt-1">အော်ဒါနံပါတ်နှင့် ဖုန်းနံပါတ်ကိုအသုံးပြု၍ Track Order တွင်
                                အော်ဒါအခြေအနေကိုစစ်ဆေးနိုင်ပါသည်</p>
                        </div>

                        <div class="border-b-2 border-dashed border-gray-200 mb-6"></div>

                        <div class="space-y-3 text-sm text-gray-700 mb-6">
                            <div class="flex justify-between items-start">
                                <span class="text-gray-500 min-w-[100px]">ရက်စွဲ</span>
                                <span class="font-semibold text-right">{{ session('order_success')['date'] }}</span>
                            </div>
                            <div class="flex justify-between items-start">
                                <span class="text-gray-500 min-w-[100px]">အော်ဒါနံပါတ်</span>
                                <span
                                    class="font-bold text-blue-600 text-right">{{ session('order_success')['order_number'] }}</span>
                            </div>
                            <div class="flex justify-between items-start">
                                <span class="text-gray-500 min-w-[100px]">အမည်</span>
                                <span class="font-bold text-blue-600 text-right">{{ session('order_success')['name'] }}</span>
                            </div>
                            <div class="flex justify-between items-start">
                                <span class="text-gray-500 min-w-[100px]">ဖုန်းနံပါတ်</span>
                                <span class="font-bold text-blue-600 text-right">{{ session('order_success')['phone'] }}</span>
                            </div>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                            <p class="text-xs text-gray-400 font-bold uppercase mb-3 tracking-wider">Items Purchased</p>

                            <div class="space-y-3">
                                @foreach (session('order_success')['items'] as $item)
                                    <div class="flex justify-between items-start text-sm group">
                                        <div class="pr-4">
                                            {{-- Product Name --}}
                                            <span class="text-gray-800 font-medium leading-relaxed block">
                                                {{ $item['name'] }}
                                            </span>
                                            {{-- Code Number (New Addition) --}}
                                            <p class="text-xs text-gray-500 mt-0.5">
                                                Code: <span class="text-blue-600 font-bold">{{ $item['code_number'] ?? '' }}</span>
                                            </p>
                                        </div>
                                        <span class="font-bold text-gray-600 whitespace-nowrap pt-0.5">x
                                            {{ $item['quantity'] }}</span>
                                    </div>
                                    <div class="border-b border-gray-200 last:border-0 border-dashed"></div>
                                @endforeach
                            </div>
                        </div>

                        <div class="mt-6 text-center">
                            <p class="text-xs text-gray-400">Thank you for shopping with Digital Mart!</p>
                        </div>
                    </div>

                    <div class="relative h-4 bg-gray-100"
                        style="background-image: radial-gradient(circle, transparent 50%, #ffffff 50%); background-size: 10px 10px; background-position: 0 5px;">
                    </div>
                </div>

                <div class="mt-4 space-y-3">
                    <button id="saveScreenshotBtn"
                        class="w-full flex items-center justify-center bg-white text-gray-800 py-3.5 rounded-xl font-bold hover:bg-gray-50 transition shadow-lg gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5 text-gray-600">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                        </svg>
                        Save Receipt Image
                    </button>

                    <p class="text-center text-white/80 text-xs pt-2">Contact Admin via:</p>

                    <div class="grid grid-cols-2 gap-3">
                        <a href="viber://chat?number=959772793448"
                            class="flex items-center justify-center bg-[#7360f2] text-white py-3 rounded-xl font-bold hover:bg-[#5e4ad1] transition shadow-lg gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M13 14c2.2 .5 3.35 1.7 4.5 4.9c.2 .5 .7 1 1.2 1.1c1.2 .2 2.3 -.4 2.8 -1.5c.7 -1.6 1.1 -3.4 1.1 -5.2c0 -6.5 -5.1 -11.9 -11.6 -12.3c-6.8 -.4 -12.5 5.2 -11.9 12c.3 3.4 2 6.5 4.8 8.4c.5 .3 .7 .8 .6 1.4l-.8 3.5c-.1 .5 .4 1 1 1h.1c1.8 0 3.5 -.6 4.9 -1.8l.8 -.7" />
                                <path d="M12 9c2.5 0 2.5 2.5 2.5 2.5" />
                                <path d="M11 8c3.5 0 3.5 3.5 3.5 3.5" />
                            </svg>
                            Viber
                        </a>

                        <a href="https://t.me/mmdigitalmart" target="_blank"
                            class="flex items-center justify-center bg-[#0088cc] text-white py-3 rounded-xl font-bold hover:bg-[#0077b5] transition shadow-lg gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M15 10l-4 4l6 6l4 -16l-18 7l4 2l2 6l3 -4" />
                            </svg>
                            Telegram
                        </a>
                    </div>

                    <button onclick="window.location.href='{{ route('home') }}'"
                        class="block w-full text-center text-white/60 hover:text-white text-sm pt-4 pb-10">
                        &larr; Back to Shopping
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- Delete Confirmation Modal --}}
    <div id="deleteConfirmModal"
        class="fixed inset-0 bg-gray-900 bg-opacity-60 hidden flex items-center justify-center z-50 backdrop-blur-sm transition-opacity">
        <div class="bg-white rounded-2xl shadow-2xl p-8 max-w-sm w-full mx-4 relative animate-[fadeIn_0.3s_ease-out]">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                    <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900">အဝယ်စာရင်းထဲကပယ်မယ်နော်</h3>
                <p class="mt-2 text-sm text-gray-500">အဝယ်စာရင်းထဲကပယ်ဖျက်မှာသေချာရဲ့လားခင်ဗျာ</p>
            </div>
            <div class="mt-6 flex justify-center gap-3">
                <button type="button" id="cancel-delete"
                    class="w-full bg-gray-200 text-gray-700 py-2.5 rounded-xl font-bold hover:bg-gray-300 transition">
                    မဖျက်တော့ဘူး
                </button>
                <button type="button" id="confirm-delete"
                    class="w-full bg-red-600 text-white py-2.5 rounded-xl font-bold hover:bg-red-700 transition shadow-lg">
                    တကယ်ဖျက်မယ်
                </button>
            </div>
        </div>
    </div>


    {{-- Remove From Cart Script --}}
    <script type="module">
        $(document).ready(function () {
            let productIdToDelete;

            // Open confirmation modal
            $(".remove-from-cart").click(function (e) {
                e.preventDefault();
                productIdToDelete = $(this).attr("data-id");
                $('#deleteConfirmModal').removeClass('hidden');
            });

            // Cancel delete action
            $("#cancel-delete").click(function () {
                $('#deleteConfirmModal').addClass('hidden');
            });

            // Confirm delete action
            $("#confirm-delete").click(function () {
                $.ajax({
                    url: '{{ route('remove_from_cart') }}',
                    method: "DELETE",
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: productIdToDelete
                    },
                    success: function (response) {
                        window.location.reload();
                    },
                    error: function () {
                        // Optionally handle errors, e.g., show an error message
                        $('#deleteConfirmModal').addClass('hidden');
                        alert('Error: Could not remove the item.');
                    }
                });
            });
        });
    </script>
    <script type="module">
        // Quantity Update Script
        $(".update-cart-qty").click(function (e) {
            e.preventDefault();

            var ele = $(this);
            var id = ele.attr("data-id");
            var action = ele.attr("data-action");
            var inputField = $(".qty-input-" + id);
            var currentQty = parseInt(inputField.val());

            var newQty = currentQty;
            if (action === "increase") {
                newQty = currentQty + 1;
            } else if (action === "decrease") {
                if (currentQty > 1) {
                    newQty = currentQty - 1;
                } else {
                    return;
                }
            }

            $.ajax({
                url: '{{ route('update_cart') }}',
                method: "PATCH",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id,
                    quantity: newQty
                },
                success: function (response) {
                    window.location.reload();
                }
            });
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <script>
        // Phone Input Logic
        document.getElementById('phoneInput')?.addEventListener('input', function (e) {
            let value = this.value;
            const myanNums = ["၀", "၁", "၂", "၃", "၄", "၅", "၆", "၇", "၈", "၉"];
            const engNums = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];
            for (let i = 0; i < 10; i++) {
                let regex = new RegExp(myanNums[i], "g");
                value = value.replace(regex, engNums[i]);
            }
            this.value = value.replace(/[^0-9]/g, '');
        });

        // Screenshot Logic
        document.getElementById('saveScreenshotBtn')?.addEventListener('click', function () {
            const element = document.getElementById('receipt-content');
            const btn = this;
            const originalText = btn.innerHTML;

            btn.innerHTML = `Saving...`;

            setTimeout(() => {
                html2canvas(element, {
                    scale: 3,
                    useCORS: true,
                    backgroundColor: null,
                    logging: false,
                }).then(canvas => {
                    let link = document.createElement('a');
                    let orderNum = "{{ session('order_success')['order_number'] ?? 'slip' }}";
                    link.download = 'DigitalMart-Receipt-' + orderNum + '.png';
                    link.href = canvas.toDataURL("image/png");
                    link.click();

                    btn.innerHTML = originalText;
                    alert("Receipt saved to Photos!");
                });
            }, 100);
        });
    </script>
@endsection