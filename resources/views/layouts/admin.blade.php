<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Digital Mart</title>

    {{-- Tailwind CSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class'
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        .nav-item.active {
            background-color: #1e40af;
            color: white;
        }

        body,
        div,
        nav,
        header,
        aside {
            transition: background-color 0.3s, color 0.3s, border-color 0.3s;
        }
    </style>

    {{-- Dark Mode Init --}}
    <script>
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia(
            '(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>

<body class="bg-gray-100 dark:bg-gray-900 font-sans text-gray-900 dark:text-gray-100">
    <div class="flex h-screen overflow-hidden">

        {{-- Sidebar (Code အတိုချုံ့ထားသည်) --}}
        <aside id="sidebar"
            class="fixed inset-y-0 left-0 z-50 w-64 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 transform -translate-x-full transition-transform duration-300 ease-in-out">
            <div class="h-16 flex items-center justify-center border-b border-gray-200 dark:border-gray-700">
                <h1 class="text-2xl font-bold text-blue-600">Digital<span
                        class="text-gray-800 dark:text-white">Mart</span></h1>
            </div>
            <div class="p-4">
                {{-- Menu Items --}}
                <nav class="space-y-1">
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600 transition {{ request()->routeIs('admin.dashboard') ? 'bg-blue-800 text-white' : 'text-gray-600 dark:text-gray-300' }}">
                        <i class="fas fa-home w-5"></i>
                        <span class="font-medium">Dashboard</span>
                    </a>
                    {{-- Other menus... --}}
                </nav>
                <nav>
                    {{-- Orders Link--}}

                    <a href="{{ route('admin.orders.index') }}"
                        class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600 transition {{ request()->routeIs('admin.orders.*') ? 'bg-blue-800 text-white' : 'text-gray-600 dark:text-gray-300' }}">
                        <i class="fas fa-shopping-cart w-5"></i>
                        <span class="font-medium">Orders</span>
                    </a>
                </nav>
                <nav>
                    {{-- Products Link --}}
                    <a href="{{ route('admin.products.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors mb-1 
                       {{ request()->routeIs('admin.products.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/30' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-blue-600' }}">

                        {{-- Icon --}}
                        <div class="w-5 flex justify-center">
                            <i class="fas fa-box {{ request()->routeIs('admin.products.*') ? 'text-white' : '' }}"></i>
                        </div>

                        {{-- Label --}}
                        <span class="font-medium">Products</span>
                    </a>
                </nav>
                <nav>
                    {{-- Categories Link --}}
                    <a href="{{ route('admin.categories.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors mb-1 
                       {{ request()->routeIs('admin.categories.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/30' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-blue-600' }}">

                        {{-- Icon --}}
                        <div class="w-5 flex justify-center">
                            <i
                                class="fas fa-tags {{ request()->routeIs('admin.categories.*') ? 'text-white' : '' }}"></i>
                        </div>

                        {{-- Label --}}
                        <span class="font-medium">Categories</span>
                    </a>

                    <a href="{{ route('admin.promotions.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors mb-1 
                       {{ request()->routeIs('admin.promotions.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/30' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-blue-600' }}">
                        <div class="w-5 flex justify-center">
                            <i class="fas fa-images {{ request()->routeIs('admin.promotions.*') ? 'text-white' : '' }}"></i>
                        </div>
                        <span class="font-medium">Promotions</span>
                    </a>

                    {{-- Admin Management (Super Admin Only) --}}
                    @if(Auth::check() && Auth::user()->isSuperAdmin())
                        <a href="{{ route('admin.users.index') }}"
                            class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors mb-1 
                                       {{ request()->routeIs('admin.users.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/30' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-blue-600' }}">

                            {{-- Icon --}}
                            <div class="w-5 flex justify-center">
                                <i class="fas fa-users {{ request()->routeIs('admin.users.*') ? 'text-white' : '' }}"></i>
                            </div>

                            {{-- Label --}}
                            <span class="font-medium">Admins</span>
                        </a>
                    @endif
                </nav>
            </div>
        </aside>

        {{-- Main Content --}}
        <div class="flex-1 flex flex-col overflow-hidden">
            <header
                class="h-16 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between px-6">

                {{-- Menu Button --}}
                <button id="sidebar-toggle" class="text-gray-500 dark:text-gray-300 focus:outline-none"><i
                        class="fas fa-bars text-xl"></i></button>
                <h2 class="text-lg font-bold text-gray-700 dark:text-white">@yield('title', 'Dashboard')</h2>

                <div class="flex items-center gap-4">

                    {{-- ========================================== --}}
                    {{-- 1. NOTIFICATION BELL & SOUND (Corrected) --}}
                    {{-- ========================================== --}}
                    <div class="relative cursor-pointer">
                        <i
                            class="fas fa-bell text-xl text-gray-500 dark:text-gray-400 hover:text-blue-600 transition"></i>
                        {{-- Badge --}}
                        <span id="notification-badge"
                            class="absolute -top-2 -right-2 bg-red-600 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full border-2 border-white dark:border-gray-800 hidden">0</span>
                    </div>

                    {{-- Audio File Correction: noti.wav --}}
                    <audio id="notification-sound" src="{{ asset('sounds/noti.wav') }}" preload="auto"></audio>
                    {{-- ========================================== --}}

                    {{-- Theme Toggle --}}
                    <button id="theme-toggle" type="button"
                        class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg text-sm p-2.5">
                        <i id="theme-toggle-dark-icon" class="fas fa-moon hidden w-5 h-5"></i>
                        <i id="theme-toggle-light-icon" class="fas fa-sun hidden w-5 h-5"></i>
                    </button>

                    {{-- Profile & Logout --}}
                    <div class="flex items-center gap-4">
                        <div class="text-right hidden sm:block">
                            <p class="text-sm font-bold text-gray-800 dark:text-white">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</p>
                        </div>
                        <form method="POST" action="{{ route('admin.logout') }}" class="inline">
                            @csrf
                            <button type="submit"
                                class="text-gray-500 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400 text-sm p-2.5 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition"
                                title="Logout">
                                <i class="fas fa-sign-out-alt w-5 h-5"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 dark:bg-gray-900 p-6">
                @yield('content')
            </main>
        </div>
    </div>

    {{-- SCRIPTS --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Theme Toggle Logic
        var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
        var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');
        var themeToggleBtn = document.getElementById('theme-toggle');

        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia(
            '(prefers-color-scheme: dark)').matches)) {
            themeToggleLightIcon.classList.remove('hidden');
            document.documentElement.classList.add('dark');
        } else {
            themeToggleDarkIcon.classList.remove('hidden');
            document.documentElement.classList.remove('dark');
        }

        themeToggleBtn.addEventListener('click', function () {
            themeToggleDarkIcon.classList.toggle('hidden');
            themeToggleLightIcon.classList.toggle('hidden');
            if (localStorage.getItem('color-theme')) {
                if (localStorage.getItem('color-theme') === 'light') {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                } else {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                }
            } else {
                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                }
            }
        });

        // ==========================================
        // 2. REAL-TIME NOTIFICATION SCRIPT
        // ==========================================
        $(document).ready(function () {
            let lastCount = 0;
            let isFirstLoad = true;
            $('body').one('click', function () {
                var audio = document.getElementById('notification-sound');
                // အသံတိုးတိုးလေးဖွင့်ပြီး ချက်ချင်းပြန်ပိတ်လိုက်မယ် (Browser ကို လှည့်စားနည်းပါ)
                audio.volume = 0.1;
                audio.play().then(() => {
                    audio.pause();
                    audio.currentTime = 0;
                    audio.volume = 1.0; // အသံပြန်ချဲ့မယ်
                }).catch(e => console.log("Audio unlock failed: " + e));
            });

            function refreshOrderTable() {
                $.ajax({
                    url: "{{ route('admin.recent.orders') }}",
                    method: "GET",
                    success: function (response) {
                        $('#recent-orders-body').html(response.html);
                    }
                });
            }

            function checkNewOrders() {
                $.ajax({
                    url: "{{ route('admin.pending.count') }}",
                    method: "GET",
                    success: function (response) {
                        let newCount = response.count;
                        let badge = $('#notification-badge');

                        if (newCount > 0) {
                            badge.text(newCount);
                            badge.removeClass('hidden');
                        } else {
                            badge.addClass('hidden');
                        }

                        if (newCount > lastCount && !isFirstLoad) {
                            // Play Sound (noti.wav)
                            try {
                                document.getElementById('notification-sound').play().catch(e => console
                                    .log("Interaction needed"));
                            } catch (e) { }

                            // Refresh Table
                            refreshOrderTable();
                        }
                        lastCount = newCount;
                        isFirstLoad = false;
                    }
                });
            }
            checkNewOrders();
            setInterval(checkNewOrders, 5000);
        });

        // Sidebar Toggle Logic
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const sidebarLinks = sidebar.querySelectorAll('a');

        sidebarToggle.addEventListener('click', (e) => {
            e.stopPropagation();
            sidebar.classList.toggle('-translate-x-full');
        });

        // Close sidebar when clicking a link
        sidebarLinks.forEach(link => {
            link.addEventListener('click', () => {
                sidebar.classList.add('-translate-x-full');
            });
        });

        // Close sidebar when clicking outside
        document.addEventListener('click', (e) => {
            if (!sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
                sidebar.classList.add('-translate-x-full');
            }
        });
    </script>

</body>

</html>
