<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital Mart</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-[#f3f4f6] font-['Poppins',sans-serif] text-slate-900">
    @php
        $cartCount = 0;
        if (session('cart')) {
            $cartCount = array_sum(array_column(session('cart'), 'quantity'));
        }
    @endphp

    <div id="toast-container" class="fixed right-4 top-24 z-50 flex flex-col gap-3"></div>

    <header class="sticky top-0 z-40 border-b border-slate-200 bg-white">
        <div class="border-b border-slate-100 bg-slate-900 text-white">
            <div class="container mx-auto flex items-center justify-between px-4 py-2 text-xs sm:text-sm">
                <p>DigitalMart online store</p>
                <a href="{{ route('track_order') }}" class="font-medium text-slate-100 transition hover:text-white">
                    Track Order
                </a>
            </div>
        </div>

        <div class="container mx-auto px-4 py-4">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center">
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-orange-500 to-pink-500 text-white shadow-sm">
                        <i class="fa-solid fa-store text-lg"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-extrabold tracking-tight text-[#1f3c88]">DigitalMart</p>
                        <p class="text-xs text-slate-500">Simple online shopping</p>
                    </div>
                </a>

                <form action="{{ route('home') }}" method="GET" class="flex flex-1 items-stretch gap-0">
                    <div class="relative flex-1">
                        <input type="text" name="search" placeholder="Search in DigitalMart"
                            value="{{ request('search', '') }}"
                            class="h-12 w-full rounded-l-md border border-slate-300 bg-slate-50 px-4 text-sm text-slate-700 placeholder:text-slate-400 focus:border-orange-400 focus:bg-white focus:outline-none">
                    </div>
                    <button type="submit"
                        class="flex h-12 w-14 items-center justify-center rounded-r-md bg-orange-500 text-white transition hover:bg-orange-600">
                        <i class="fa-solid fa-magnifying-glass text-sm"></i>
                    </button>
                </form>

                <div class="flex items-center gap-3">
                    <a href="{{ route('track_order') }}"
                        class="hidden rounded-md border border-slate-300 px-4 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-50 sm:inline-flex">
                        Track Order
                    </a>
                    <a href="{{ route('cart.index') }}"
                        class="relative inline-flex h-12 w-12 items-center justify-center rounded-md border border-slate-300 bg-white text-slate-700 transition hover:bg-slate-50">
                        <i class="fa-solid fa-cart-shopping text-lg"></i>
                        <span
                            class="absolute -right-2 -top-2 inline-flex min-h-[22px] min-w-[22px] items-center justify-center rounded-full bg-pink-500 px-1 text-[11px] font-bold text-white">
                            {{ $cartCount }}
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <main class="flex-grow">
        @yield('content')
    </main>

    <footer class="mt-12 border-t border-slate-200 bg-white">
        <div class="container mx-auto flex flex-col gap-4 px-4 py-8 text-sm text-slate-500 md:flex-row md:items-center md:justify-between">
            <p>&copy; {{ date('Y') }} Digital Mart. All rights reserved.</p>
            <div class="flex items-center gap-5">
                <a href="{{ route('home') }}" class="transition hover:text-slate-900">Home</a>
                <a href="{{ route('cart.index') }}" class="transition hover:text-slate-900">Cart</a>
                <a href="{{ route('track_order') }}" class="transition hover:text-slate-900">Track Order</a>
            </div>
        </div>
    </footer>
</body>

</html>
