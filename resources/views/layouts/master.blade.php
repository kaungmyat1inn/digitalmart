<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital Mart</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        /* Pagination Styles */
        .pagination {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
        }

        .pagination .page-item {
            list-style: none;
        }

        .pagination .page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 2.5rem;
            height: 2.5rem;
            padding: 0 0.75rem;
            border-radius: 0.5rem;
            background-color: white;
            color: #374151;
            font-weight: 500;
            font-size: 0.875rem;
            border: 1px solid #e5e7eb;
            transition: all 0.2s;
        }

        .pagination .page-link:hover {
            background-color: #eff6ff;
            border-color: #3b82f6;
            color: #2563eb;
        }

        .pagination .page-item.active .page-link {
            background-color: #3b82f6;
            border-color: #3b82f6;
            color: white;
        }

        .pagination .page-item.disabled .page-link {
            background-color: transparent;
            color: #9ca3af;
            border-color: transparent;
        }

        .pagination .page-link svg {
            width: 1rem;
            height: 1rem;
        }
    </style>
</head>

<body class="bg-gray-50 flex flex-col min-h-screen">

    <nav class="bg-white shadow-sm border-b border-gray-100 sticky top-0 z-50">

        <div class="container mx-auto px-4 h-20 flex justify-between items-center">

            <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                <div class="bg-blue-600 text-white p-2 rounded-lg group-hover:bg-blue-700 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72l1.189-1.19A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .414.336.75.75.75z" />
                    </svg>
                </div>
                <span class="text-2xl font-bold text-gray-800 tracking-tight">Digital <span
                        class="text-blue-600">Mart</span></span>
            </a>

            <div class="hidden md:flex flex-1 max-w-lg mx-8">
                <form action="{{ route('home') }}" method="GET" class="relative w-full flex items-center">
                    <input type="text" name="search" placeholder="Search products..."
                        value="{{ request('search', '') }}"
                        class="w-full bg-gray-100 text-gray-700 rounded-full py-2.5 pr-24 pl-6 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    <div class="absolute right-2 flex items-center gap-1">
                        @if(request('search'))
                            <a href="{{ route('home') }}" class="text-gray-400 hover:text-gray-600 p-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </a>
                        @endif
                        <button type="submit" class="bg-blue-600 text-white p-1.5 rounded-full hover:bg-blue-700 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>

            <div class="flex items-center gap-6">
                <a href="{{ route('cart.index') }}" class="relative group">

                    <div class="p-2 rounded-full hover:bg-gray-100 transition">

                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-7 h-7 text-gray-700 group-hover:text-blue-600">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                        </svg>
                        <span
                            class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-bold h-5 w-5 flex items-center justify-center rounded-full border-2 border-white shadow-sm">
                            {{ count((array) session('cart')) }}
                        </span>
                    </div>
                </a>
                <a href="{{ route('track_order') }}"
                    class="text-gray-700 hover:text-blue-600 font-medium transition">Track Order</a>
            </div>
        </div>
    </nav>

    <main class="flex-grow">
        @yield('content')
    </main>

    <footer class="bg-gray-900 text-gray-300 py-10 mt-12">
        <div class="container mx-auto px-4 text-center">
            <h3 class="text-2xl font-bold text-white mb-4">Digital Mart</h3>
            <p class="text-gray-400 mb-6">Your one-stop shop for all digital needs.</p>
            <div class="border-t border-gray-800 pt-6 text-sm">
                &copy; {{ date('Y') }} Digital Mart. All rights reserved.
            </div>
        </div>
    </footer>

</body>

</html>