<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital Mart</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                            950: '#172554',
                        },
                        secondary: {
                            50: '#fdf4ff',
                            100: '#fae8ff',
                            200: '#f5d0fe',
                            300: '#f0abfc',
                            400: '#e879f9',
                            500: '#d946ef',
                            600: '#c026d3',
                            700: '#a21caf',
                            800: '#86198f',
                            900: '#701a75',
                        },
                        dark: {
                            50: '#f8fafc',
                            100: '#f1f5f9',
                            200: '#e2e8f0',
                            300: '#cbd5e1',
                            400: '#94a3b8',
                            500: '#64748b',
                            600: '#475569',
                            700: '#334155',
                            800: '#1e293b',
                            900: '#0f172a',
                            950: '#020617',
                        }
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'slide-up': 'slideUp 0.5s ease-out',
                        'slide-down': 'slideDown 0.3s ease-out',
                        'fade-in': 'fadeIn 0.5s ease-out',
                        'scale-in': 'scaleIn 0.3s ease-out',
                        'shimmer': 'shimmer 2s linear infinite',
                        'bounce-slow': 'bounce 3s infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-20px)' },
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(20px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
                        },
                        slideDown: {
                            '0%': { transform: 'translateY(-10px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
                        },
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        scaleIn: {
                            '0%': { transform: 'scale(0.95)', opacity: '0' },
                            '100%': { transform: 'scale(1)', opacity: '1' },
                        },
                        shimmer: {
                            '0%': { backgroundPosition: '-200% 0' },
                            '100%': { backgroundPosition: '200% 0' },
                        },
                    },
                    backgroundImage: {
                        'gradient-radial': 'radial-gradient(var(--tw-gradient-stops))',
                        'gradient-conic': 'conic-gradient(from 180deg at 50% 50%, var(--tw-gradient-stops))',
                        'mesh-gradient': 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
                    },
                    boxShadow: {
                        'glow': '0 0 40px -10px rgba(59, 130, 246, 0.4)',
                        'glow-lg': '0 0 60px -15px rgba(59, 130, 246, 0.5)',
                        'inner-glow': 'inset 0 2px 4px 0 rgba(255, 255, 255, 0.06)',
                        'glass': '0 8px 32px 0 rgba(31, 38, 135, 0.15)',
                    },
                    backdropBlur: {
                        xs: '2px',
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: linear-gradient(to bottom, #f1f5f9, #e2e8f0);
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(to bottom, #3b82f6, #8b5cf6);
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(to bottom, #2563eb, #7c3aed);
        }
        
        /* Glass morphism */
        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .glass-dark {
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        /* Gradient text */
        .gradient-text {
            background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 50%, #d946ef 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        /* Animated gradient background */
        .animated-gradient {
            background: linear-gradient(-45deg, #3b82f6, #8b5cf6, #d946ef, #f97316);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }
        
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        /* Shimmer effect */
        .shimmer {
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            background-size: 200% 100%;
            animation: shimmer 2s infinite;
        }
        
        /* Pulse ring */
        .pulse-ring {
            animation: pulse-ring 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        
        @keyframes pulse-ring {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.5); opacity: 0; }
        }
        
        /* Smooth transitions */
        * {
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        /* Focus styles */
        input:focus, button:focus, a:focus {
            outline: none;
        }
        
        /* Selection color */
        ::selection {
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            color: white;
        }
        
        /* Loading skeleton */
        .skeleton {
            background: linear-gradient(90deg, #f1f5f9 25%, #e2e8f0 50%, #f1f5f9 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 min-h-screen flex flex-col">
    
    <!-- Toast Notification Container -->
    <div id="toast-container" class="fixed top-24 right-4 z-50 flex flex-col gap-3"></div>

    <!-- Navigation -->
    <nav class="fixed top-0 left-0 right-0 z-50 transition-all duration-300" id="navbar">
        <div class="absolute inset-0 bg-white/80 backdrop-blur-xl border-b border-white/20 shadow-lg"></div>
        
        <div class="relative container mx-auto px-4">
            <div class="flex items-center justify-between h-20">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="relative">
                        <div class="w-12 h-12 bg-gradient-to-br from-primary-500 to-secondary-500 rounded-2xl flex items-center justify-center shadow-lg shadow-primary-500/30 group-hover:shadow-primary-500/50 group-hover:scale-110 transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-7 h-7 text-white">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72l1.189-1.19A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .414.336.75.75.75z" />
                            </svg>
                        </div>
                        <div class="absolute -top-1 -right-1 w-4 h-4 bg-secondary-500 rounded-full border-2 border-white animate-pulse"></div>
                    </div>
                    <div>
                        <span class="text-2xl font-bold tracking-tight">
                            Digital<span class="gradient-text">Mart</span>
                        </span>
                        <p class="text-xs text-gray-500 -mt-1">Premium Gadgets Store</p>
                    </div>
                </a>

                <!-- Search Bar -->
                <div class="hidden lg:flex flex-1 max-w-xl mx-8">
                    <form action="{{ route('home') }}" method="GET" class="relative w-full">
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 group-focus-within:text-primary-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                </svg>
                            </div>
                            <input type="text" name="search" placeholder="Search products..." value="{{ request('search', '') }}"
                                class="w-full bg-white/50 border border-gray-200 rounded-2xl py-3 pl-12 pr-24 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all duration-300 backdrop-blur-sm">
                            <div class="absolute inset-y-0 right-2 flex items-center">
                                @if(request('search'))
                                    <a href="{{ route('home') }}" class="p-2 text-gray-400 hover:text-gray-600 rounded-xl hover:bg-gray-100 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </a>
                                @endif
                                <button type="submit" class="px-4 py-1.5 bg-gradient-to-r from-primary-500 to-primary-600 text-white rounded-xl font-medium hover:from-primary-600 hover:to-primary-700 transition-all duration-300 shadow-lg shadow-primary-500/30 hover:shadow-primary-500/40">
                                    Search
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Right Actions -->
                <div class="flex items-center gap-2">
                    <!-- Track Order Button -->
                    <a href="{{ route('track_order') }}" class="hidden sm:flex items-center gap-2 px-4 py-2.5 text-gray-600 hover:text-primary-600 hover:bg-primary-50 rounded-xl font-medium transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <span class="hidden md:inline">Track Order</span>
                    </a>

                    <!-- Cart Button -->
                    <a href="{{ route('cart.index') }}" class="relative group">
                        <div class="flex items-center justify-center w-12 h-12 bg-white border border-gray-200 rounded-2xl shadow-sm group-hover:shadow-lg group-hover:shadow-primary-500/10 group-hover:border-primary-200 transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-700 group-hover:text-primary-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                            </svg>
                            @php
                                $cartCount = 0;
                                if(session('cart')) {
                                    $cartCount = array_sum(array_column(session('cart'), 'quantity'));
                                }
                            @endphp
                            <span class="absolute -top-1.5 -right-1.5 w-6 h-6 bg-gradient-to-r from-red-500 to-red-600 text-white text-xs font-bold rounded-full flex items-center justify-center shadow-lg shadow-red-500/30 border-2 border-white transition-all duration-300 transform scale-0 group-hover:scale-100 {{ $cartCount > 0 ? 'scale-100' : '' }}">
                                {{ $cartCount > 0 ? $cartCount : '0' }}
                            </span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow pt-20">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="relative mt-20 overflow-hidden">
        <!-- Animated Background -->
        <div class="absolute inset-0 bg-gradient-to-br from-dark-900 via-dark-800 to-dark-900"></div>
        <div class="absolute inset-0 opacity-30">
            <div class="absolute top-0 left-1/4 w-96 h-96 bg-primary-500 rounded-full filter blur-[128px] animate-pulse-slow"></div>
            <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-secondary-500 rounded-full filter blur-[128px] animate-pulse-slow animation-delay-2000"></div>
        </div>
        
        <div class="relative container mx-auto px-4 py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
                <!-- Brand -->
                <div class="lg:col-span-1">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-gradient-to-br from-primary-500 to-secondary-500 rounded-2xl flex items-center justify-center shadow-lg shadow-primary-500/30">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-7 h-7 text-white">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72l1.189-1.19A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .414.336.75.75.75z" />
                            </svg>
                        </div>
                        <span class="text-2xl font-bold text-white">Digital<span class="gradient-text">Mart</span></span>
                    </div>
                    <p class="text-gray-400 mb-6 leading-relaxed">
                        Your one-stop shop for premium gadgets and electronics. Quality guaranteed with fast delivery nationwide.
                    </p>
                    <div class="flex gap-4">
                        <a href="#" class="w-10 h-10 bg-white/10 hover:bg-primary-500 rounded-xl flex items-center justify-center text-white hover:text-white transition-all duration-300 hover:scale-110">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-white/10 hover:bg-primary-500 rounded-xl flex items-center justify-center text-white hover:text-white transition-all duration-300 hover:scale-110">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-white/10 hover:bg-primary-500 rounded-xl flex items-center justify-center text-white hover:text-white transition-all duration-300 hover:scale-110">
                            <i class="fab fa-twitter"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-lg font-bold text-white mb-6">Quick Links</h4>
                    <ul class="space-y-3">
                        <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-primary-500"></i> Home</a></li>
                        <li><a href="{{ route('cart.index') }}" class="text-gray-400 hover:text-white transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-primary-500"></i> Shopping Cart</a></li>
                        <li><a href="{{ route('track_order') }}" class="text-gray-400 hover:text-white transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-primary-500"></i> Track Order</a></li>
                    </ul>
                </div>

                <!-- Customer Service -->
                <div>
                    <h4 class="text-lg font-bold text-white mb-6">Customer Service</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-primary-500"></i> Contact Us</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-primary-500"></i> FAQs</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-primary-500"></i> Shipping Info</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-primary-500"></i> Returns & Refunds</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div>
                    <h4 class="text-lg font-bold text-white mb-6">Contact Us</h4>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-3 text-gray-400">
                            <i class="fas fa-map-marker-alt mt-1 text-primary-500"></i>
                            <span>Yangon, Myanmar</span>
                        </li>
                        <li class="flex items-center gap-3 text-gray-400">
                            <i class="fas fa-phone text-primary-500"></i>
                            <span>+95 9 123 456 789</span>
                        </li>
                        <li class="flex items-center gap-3 text-gray-400">
                            <i class="fas fa-envelope text-primary-500"></i>
                            <span>info@digitalmart.com</span>
                        </li>
                        <li class="flex items-center gap-3 text-gray-400">
                            <i class="fas fa-clock mt-1 text-primary-500"></i>
                            <span>Mon-Sat: 9AM - 8PM</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="border-t border-white/10 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-gray-400 text-sm">&copy; {{ date('Y') }} Digital Mart. All rights reserved.</p>
                <div class="flex items-center gap-6">
                    <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">Privacy Policy</a>
                    <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scroll to Top Button -->
    <button id="scrollToTop" class="fixed bottom-8 right-8 w-12 h-12 bg-gradient-to-r from-primary-500 to-secondary-500 text-white rounded-2xl shadow-lg shadow-primary-500/30 opacity-0 invisible transition-all duration-300 hover:scale-110 hover:shadow-xl z-40 flex items-center justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
        </svg>
    </button>

    <script>
        // Scroll to Top Button
        const scrollBtn = document.getElementById('scrollToTop');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 500) {
                scrollBtn.classList.remove('opacity-0', 'invisible');
            } else {
                scrollBtn.classList.add('opacity-0', 'invisible');
            }
        });
        scrollBtn.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        // Navbar scroll effect
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.add('shadow-xl');
            } else {
                navbar.classList.remove('shadow-xl');
            }
        });
    </script>
</body>
</html>

