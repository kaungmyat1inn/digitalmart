@extends('layouts.master')

@if (session('error'))
    <div class="bg-red-500 text-white p-4 text-center font-bold sticky top-20 z-50 shadow-lg animate-pulse">
        {{ session('error') }}
    </div>
@endif

@section('content')
    <!-- Hero Section -->
    <div class="relative bg-gradient-to-br from-indigo-900 via-blue-800 to-purple-900 text-white overflow-hidden">
        <!-- Animated Background -->
        <div class="absolute inset-0 overflow-hidden">
            <div
                class="absolute -top-40 -right-40 w-80 h-80 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob">
            </div>
            <div
                class="absolute -bottom-40 -left-40 w-80 h-80 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000">
            </div>
            <div
                class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-indigo-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-pulse">
            </div>
        </div>

        <!-- Floating Particles -->
        <div class="absolute inset-0" id="particles"></div>

        <div class="container mx-auto px-4 py-20 md:py-32 relative z-10">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-12">
                <div class="lg:w-1/2 space-y-8">
                    <div
                        class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm px-4 py-2 rounded-full border border-white/20">
                        <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                        <span class="text-sm font-medium">New Arrivals 2024</span>
                    </div>

                    <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold leading-tight">
                        Upgrade Your <br>
                        <span
                            class="text-transparent bg-clip-text bg-gradient-to-r from-blue-300 via-purple-300 to-pink-300">Digital
                            Life</span>
                    </h1>

                    <p class="text-lg md:text-xl text-blue-100 max-w-xl leading-relaxed">
                        Discover the latest gadgets, electronics, and accessories at unbeatable prices.
                        Quality guaranteed with fast delivery nationwide.
                    </p>

                    <div class="flex flex-wrap gap-4">
                        <button onclick="scrollToProducts()"
                            class="group bg-white text-indigo-900 hover:bg-blue-50 font-bold py-4 px-8 rounded-full shadow-xl transition-all duration-300 transform hover:scale-105 hover:shadow-2xl flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                            Shop Now
                        </button>
                        <button onclick="trackOrderScroll()"
                            class="group bg-transparent border-2 border-white/30 hover:border-white text-white font-bold py-4 px-8 rounded-full transition-all duration-300 hover:bg-white/10 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            Track Order
                        </button>
                    </div>

                    <!-- Stats -->
                    <div class="flex gap-8 pt-4">
                        <div>
                            <div class="text-3xl font-bold">500+</div>
                            <div class="text-blue-200 text-sm">Products</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold">10K+</div>
                            <div class="text-blue-200 text-sm">Customers</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold">4.9★</div>
                            <div class="text-blue-200 text-sm">Rating</div>
                        </div>
                    </div>
                </div>

                <div class="lg:w-1/2 relative">
                    <div class="relative w-full max-w-lg mx-auto">
                        <!-- Main Image -->
                        <div
                            class="relative bg-white/10 backdrop-blur-lg rounded-3xl p-8 shadow-2xl transform hover:rotate-1 transition duration-500">
                            <img src="https://placehold.co/600x400/png?text=Premium+Gadgets" alt="Hero Image"
                                class="w-full rounded-xl shadow-lg">

                            <!-- Floating Badges -->
                            <div
                                class="absolute -top-4 -right-4 bg-gradient-to-r from-pink-500 to-purple-500 text-white px-4 py-2 rounded-full text-sm font-bold shadow-lg animate-bounce">
                                🔥 Hot Deal
                            </div>
                            <div
                                class="absolute -bottom-4 -left-4 bg-white text-indigo-900 px-4 py-2 rounded-full text-sm font-bold shadow-lg">
                                🆓 Free Shipping
                            </div>
                        </div>

                        <!-- Decorative Elements -->
                        <div
                            class="absolute -z-10 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-full h-full bg-gradient-to-r from-blue-500 to-purple-500 rounded-full filter blur-3xl opacity-20">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Wave Divider -->
        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M0 120L60 110C120 100 240 80 360 70C480 60 600 60 720 65C840 70 960 80 1080 85C1200 90 1320 90 1380 90L1440 90V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z"
                    fill="#f9fafb" />
            </svg>
        </div>
    </div>

    <!-- Main Content -->
    <div class="bg-gray-50 min-h-screen" id="products-section">
        <div class="container mx-auto px-4 py-16">

            @if($search)
                <!-- Search Results -->
                <div class="flex items-center justify-between mb-8 flex-wrap gap-4">
                    <div>
                        <h2 class="text-3xl font-bold text-gray-800">Search Results for "{{ $search }}"</h2>
                        <p class="text-gray-500 mt-1">{{ $products->total() }} products found</p>
                    </div>
                    <a href="{{ route('home') }}"
                        class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 font-medium px-4 py-2 rounded-lg hover:bg-blue-50 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Clear Search
                    </a>
                </div>
            @else
                <!-- Section Header -->
                <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
                    <div>
                        <h2 class="text-3xl font-bold text-gray-800 flex items-center gap-3">
                            <span class="w-1 h-8 bg-gradient-to-b from-blue-500 to-purple-500 rounded-full"></span>
                            Popular Products
                        </h2>
                        <p class="text-gray-500 mt-1">Handpicked just for you</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="#"
                            class="text-blue-600 hover:text-blue-700 font-medium flex items-center gap-1 px-4 py-2 rounded-lg hover:bg-blue-50 transition">
                            View All
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </a>
                    </div>
                </div>
            @endif

            <!-- Products Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                @foreach ($products as $product)
                    <div class="group bg-white rounded-2xl shadow-sm hover:shadow-2xl transition-all duration-500 border border-gray-100 overflow-hidden transform hover:-translate-y-2 {{ $product->stock > 0 ? 'cursor-pointer' : 'cursor-not-allowed opacity-75' }}"
                        onclick="{{ $product->stock > 0 ? 'openProductModal(this)' : '' }}" data-id="{{ $product->id }}"
                        data-name="{{ $product->name }}" data-price="{{ number_format($product->price) }}"
                        data-image="{{ asset('storage/' . $product->image) }}" data-category="{{ $product->category->name }}"
                        data-code="{{ $product->code_number }}" data-add-cart-url="{{ route('add_to_cart', $product->id) }}"
                        data-description="{{ $product->description }}" data-stock="{{ $product->stock }}">

                        <!-- Image Container -->
                        <div class="relative overflow-hidden aspect-square bg-gradient-to-br from-gray-100 to-gray-200">
                            <!-- Category Badge -->
                            <span
                                class="absolute top-3 left-3 z-10 bg-white/90 backdrop-blur-sm text-xs font-bold px-3 py-1.5 rounded-full text-gray-700 shadow-md border border-gray-200">
                                {{ $product->category->name }}
                            </span>

                            <!-- Stock Badge -->
                            @if($product->stock <= 0)
                                <span
                                    class="absolute top-3 right-3 z-10 bg-red-500 text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-md">
                                    Out of Stock
                                </span>
                                <div class="absolute inset-0 bg-gray-900/50 z-0"></div>
                            @elseif($product->stock <= 5)
                                <span
                                    class="absolute top-3 right-3 z-10 bg-orange-500 text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-md animate-pulse">
                                    Only {{ $product->stock }} left
                                </span>
                            @endif

                            <!-- Product Image -->
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">

                            <!-- Quick Action Button -->
                            @if($product->stock > 0)
                                <div
                                    class="absolute bottom-3 right-3 transform translate-y-20 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300">
                                    <button onclick="event.stopPropagation(); quickView({{ $product->id }})"
                                        class="bg-white text-gray-800 p-3 rounded-full shadow-lg hover:bg-blue-600 hover:text-white transition-all duration-300 transform hover:scale-110">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                </div>
                            @endif
                        </div>

                        <!-- Product Info -->
                        <div class="p-4 space-y-3">
                            <h3
                                class="font-bold text-gray-800 leading-snug group-hover:text-blue-600 transition-colors duration-300 line-clamp-2">
                                {{ $product->name }}
                            </h3>

                            <div class="flex items-center gap-2 text-xs text-gray-400">
                                <span class="font-mono bg-gray-100 px-2 py-1 rounded">{{ $product->code_number }}</span>
                            </div>

                            <div class="flex items-center justify-between pt-2">
                                @if($product->stock > 0)
                                    <div class="flex items-baseline gap-1">
                                        <span class="text-xl font-bold text-blue-600">{{ number_format($product->price) }}</span>
                                        <span class="text-sm text-gray-500">ကျပ်</span>
                                    </div>
                                @else
                                    <span class="text-red-500 font-bold">Out of Stock</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $products->links() }}
            </div>
        </div>
    </div>

    <!-- Product Details Modal -->
    <div id="productModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!-- Backdrop with blur -->
        <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="closeProductModal()"></div>

        <!-- Modal Container -->
        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4">
                <div class="relative w-full max-w-4xl bg-white rounded-3xl shadow-2xl transform transition-all duration-500 scale-95 opacity-0"
                    id="modalPanel">
                    <!-- Close Button -->
                    <button type="button" onclick="closeProductModal()"
                        class="absolute top-4 right-4 z-20 bg-white/80 hover:bg-white text-gray-500 hover:text-gray-700 rounded-full p-2 shadow-lg transition-all duration-300 hover:scale-110">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <div class="grid grid-cols-1 md:grid-cols-2">
                        <!-- Product Image -->
                        <div
                            class="relative bg-gradient-to-br from-gray-100 to-gray-200 p-8 md:min-h-[500px] flex items-center justify-center">
                            <img id="modalImage" src="" alt="Product Image"
                                class="max-w-full max-h-[400px] object-contain rounded-2xl shadow-lg transform transition-transform duration-500 hover:scale-105">

                            <!-- Stock Badge -->
                            <span id="modalStockBadge"
                                class="absolute top-4 left-4 px-3 py-1 rounded-full text-sm font-bold hidden"></span>
                        </div>

                        <!-- Product Details -->
                        <div class="p-8 flex flex-col">
                            <div class="mb-auto space-y-4">
                                <!-- Category -->
                                <span id="modalCategory"
                                    class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold tracking-wider uppercase bg-blue-100 text-blue-700">
                                </span>

                                <!-- Title -->
                                <h2 id="modalTitle" class="text-2xl md:text-3xl font-bold text-gray-900 leading-tight">
                                </h2>

                                <!-- Code -->
                                <p class="text-sm text-gray-500 font-mono bg-gray-100 inline-block px-3 py-1 rounded-lg">
                                    Code: <span id="modalCode"></span>
                                </p>

                                <!-- Price -->
                                <div class="py-4 border-y border-gray-100">
                                    <div class="flex items-baseline gap-2">
                                        <span id="modalPrice" class="text-3xl font-bold text-blue-600"></span>
                                        <span class="text-gray-500 text-lg">ကျပ်</span>
                                    </div>
                                </div>

                                <!-- Description -->
                                <div>
                                    <h3 class="font-bold text-gray-900 mb-2 flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-500" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        Description
                                    </h3>
                                    <p id="modalDescription" class="text-gray-600 leading-relaxed"></p>
                                </div>

                                <!-- Variants -->
                                <div>
                                    <h3 class="font-bold text-gray-900 mb-3 flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-500" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                        </svg>
                                        Available Variants
                                    </h3>
                                    <div id="modalVariants" class="flex flex-wrap gap-2"></div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex items-center gap-4 pt-6 mt-6 border-t border-gray-100">
                                <a id="modalAddToCart" href="#"
                                    class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-3 text-sm font-bold text-white bg-gradient-to-r from-blue-500 to-blue-600 rounded-full shadow-lg hover:from-blue-600 hover:to-blue-700 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    Add to Cart
                                </a>
                                <button onclick="addToWishlist()"
                                    class="p-3 rounded-full border-2 border-gray-200 text-gray-400 hover:border-pink-500 hover:text-pink-500 transition-all duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Get products data from the current page for modal
        const getCurrentProducts = () => @json($products->items());
        let selectedVariantId = null;

        // Toast notification
        function showToast(message, type = 'success') {
            const toast = document.getElementById('toast');
            const toastMessage = document.getElementById('toastMessage');
            const toastBg = toast.querySelector('div');

            toastMessage.textContent = message;
            toastBg.className = `text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-3 ${type === 'success' ? 'bg-green-500' : 'bg-red-500'}`;

            toast.classList.remove('hidden', 'translate-y-full', 'opacity-0');

            setTimeout(() => {
                toast.classList.add('translate-y-full', 'opacity-0');
                setTimeout(() => toast.classList.add('hidden'), 500);
            }, 3000);
        }

        // Update cart count in header
        function updateCartCount() {
            // Select the cart count span element (inside the cart link)
            const cartCountElements = document.querySelectorAll('nav .flex.items-center.gap-6 a[href*="cart"] span[class*="bg-red"]');
            fetch('/cart/count')
                .then(response => response.json())
                .then(data => {
                    cartCountElements.forEach(el => {
                        el.textContent = data.count || '0';
                        el.style.display = data.count > 0 ? 'flex' : 'none';
                    });
                })
                .catch(() => { });
        }

        // Quick view function
        function quickView(productId) {
            const product = document.querySelector(`[data-id="${productId}"]`);
            if (product) openProductModal(product);
        }

        // Scroll to products
        function scrollToProducts() {
            document.getElementById('products-section').scrollIntoView({ behavior: 'smooth' });
        }

        // Track order scroll
        function trackOrderScroll() {
            window.scrollTo({ top: document.body.scrollHeight, behavior: 'smooth' });
        }

        function openProductModal(element) {
            const modal = document.getElementById('productModal');
            const modalPanel = document.getElementById('modalPanel');
            const data = element.dataset;

            // Reset selected variant
            selectedVariantId = null;

            // Populate Modal Data
            document.getElementById('modalImage').src = data.image;
            document.getElementById('modalCategory').textContent = data.category;
            document.getElementById('modalTitle').textContent = data.name;
            document.getElementById('modalCode').textContent = data.code;
            document.getElementById('modalPrice').textContent = data.price;
            document.getElementById('modalAddToCart').href = data.addCartUrl;
            document.getElementById('modalDescription').textContent = data.description || 'No description available.';

            // Stock badge
            const stockBadge = document.getElementById('modalStockBadge');
            if (parseInt(data.stock) <= 0) {
                stockBadge.textContent = 'Out of Stock';
                stockBadge.className = 'absolute top-4 left-4 px-3 py-1 rounded-full text-sm font-bold bg-red-500 text-white';
                stockBadge.classList.remove('hidden');
            } else if (parseInt(data.stock) <= 5) {
                stockBadge.textContent = `Only ${data.stock} left!`;
                stockBadge.className = 'absolute top-4 left-4 px-3 py-1 rounded-full text-sm font-bold bg-orange-500 text-white animate-pulse';
                stockBadge.classList.remove('hidden');
            } else {
                stockBadge.classList.add('hidden');
            }

            // Variants
            let variants = [];
            const currentId = parseInt(data.id);
            const currentProducts = getCurrentProducts();
            const currentProduct = currentProducts.find(p => p.id == currentId);

            if (currentProduct && currentProduct.variants && currentProduct.variants.length > 0) {
                variants = currentProduct.variants;
            }

            const variantsDiv = document.getElementById('modalVariants');
            variantsDiv.innerHTML = '';
            if (variants.length > 0) {
                variants.forEach(variant => {
                    const btn = document.createElement('button');
                    btn.className = 'px-4 py-2 rounded-xl border-2 border-gray-200 bg-white text-gray-700 text-sm font-semibold hover:border-blue-500 hover:bg-blue-50 hover:text-blue-600 transition-all duration-300 cursor-pointer';
                    btn.textContent = `${variant.name} (${variant.code_number})`;
                    btn.onclick = function () {
                        // Remove selected state from all buttons
                        document.querySelectorAll('#modalVariants button').forEach(b => {
                            b.classList.remove('bg-blue-600', 'text-white', 'border-blue-600');
                            b.classList.add('bg-white', 'text-gray-700', 'border-gray-200');
                        });
                        // Add selected state to clicked button
                        btn.classList.remove('bg-white', 'text-gray-700', 'border-gray-200');
                        btn.classList.add('bg-blue-600', 'text-white', 'border-blue-600');
                        selectedVariantId = variant.id;

                        // Open variant product
                        const el = document.querySelector(`[data-id="${variant.id}"]`);
                        if (el) openProductModal(el);
                    };
                    variantsDiv.appendChild(btn);
                });
            } else {
                variantsDiv.innerHTML = '<span class="text-sm text-gray-400 italic">No other variants available</span>';
            }

            // Show Modal with animation
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';

            // Animate modal panel
            setTimeout(() => {
                modalPanel.classList.remove('scale-95', 'opacity-0');
                modalPanel.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeProductModal() {
            const modal = document.getElementById('productModal');
            const modalPanel = document.getElementById('modalPanel');

            // Animate out
            modalPanel.classList.remove('scale-100', 'opacity-100');
            modalPanel.classList.add('scale-95', 'opacity-0');

            setTimeout(() => {
                modal.classList.add('hidden');
                document.body.style.overflow = '';
            }, 300);
        }

        // Close on Escape key
        document.addEventListener('keydown', function (event) {
            if (event.key === "Escape") {
                closeProductModal();
            }
        });

        // Create floating particles
        function createParticles() {
            const container = document.getElementById('particles');
            for (let i = 0; i < 20; i++) {
                const particle = document.createElement('div');
                particle.className = 'absolute w-2 h-2 bg-white/10 rounded-full';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.top = Math.random() * 100 + '%';
                particle.style.animation = `float ${3 + Math.random() * 4}s ease-in-out infinite`;
                particle.style.animationDelay = Math.random() * 2 + 's';
                container.appendChild(particle);
            }
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', function () {
            createParticles();
            updateCartCount();
        });
    </script>

    <style>
        /* Custom Animations */
        @keyframes blob {

            0%,
            100% {
                transform: translate(0, 0) scale(1);
            }

            25% {
                transform: translate(20px, -20px) scale(1.1);
            }

            50% {
                transform: translate(-20px, 20px) scale(0.9);
            }

            75% {
                transform: translate(20px, 20px) scale(1.05);
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0) scale(1);
                opacity: 0.3;
            }

            50% {
                transform: translateY(-30px) scale(1.2);
                opacity: 0.6;
            }
        }

        .animate-blob {
            animation: blob 7s infinite;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        /* Line clamp for product names */
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Smooth scroll */
        html {
            scroll-behavior: smooth;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(to bottom, #3b82f6, #8b5cf6);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(to bottom, #2563eb, #7c3aed);
        }
    </style>
@endsection