@extends('layouts.master')

@if (session('error'))
    <div class="bg-red-500 text-white p-4 text-center font-bold sticky top-20 z-50 shadow-lg animate-pulse">
        {{ session('error') }}
    </div>
@endif

@section('content')
    <div class="relative bg-gradient-to-r from-blue-700 to-indigo-800 text-white overflow-hidden">
        <div class="absolute inset-0 opacity-20 bg-[url('https://placehold.co/1920x600/png?text=')] bg-cover bg-center">
        </div>
        <div
            class="container mx-auto px-4 py-16 md:py-24 relative z-10 flex flex-col md:flex-row items-center justify-between">
            <div class="md:w-1/2 space-y-6">
                <span
                    class="bg-blue-500/30 text-blue-100 px-3 py-1 rounded-full text-sm font-medium border border-blue-400/30">
                    New Arrivals
                </span>
                <h1 class="text-4xl md:text-6xl font-bold leading-tight">
                    Upgrade Your <br> <span class="text-blue-300">Digital Life</span>
                </h1>
                <p class="text-lg text-blue-100 max-w-lg">
                    Discover the latest gadgets, electronics, and accessories at unbeatable prices. Quality guaranteed.
                </p>
                <button
                    class="bg-white text-blue-700 hover:bg-gray-100 font-bold py-3 px-8 rounded-full shadow-lg transition transform hover:scale-105">
                    Shop Now
                </button>
            </div>
            <div class="md:w-1/2 mt-10 md:mt-0 flex justify-center">
                <img src="https://placehold.co/500x300/png?text=Gadgets" alt="Hero Image"
                    class="rounded-xl shadow-2xl rotate-3 hover:rotate-0 transition duration-500">
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-16">

        <div class="flex items-center justify-between mb-8">
            <h2 class="text-3xl font-bold text-gray-800">Popular Products</h2>
            <a href="#" class="text-blue-600 hover:text-blue-700 font-medium flex items-center gap-1">
                View All
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
            </a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
            @foreach ($products as $product)
                <div class="bg-gray-50 rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 group border border-gray-200 flex flex-col h-full cursor-pointer"
                    onclick="openProductModal(this)" data-id="{{ $product->id }}" data-name="{{ $product->name }}"
                    data-price="{{ number_format($product->price) }}" data-image="{{ asset('storage/' . $product->image) }}"
                    data-category="{{ $product->category->name }}" data-code="{{ $product->code_number }}"
                    data-add-cart-url="{{ route('add_to_cart', $product->id) }}" data-description="{{ $product->description }}">

                    <div class="relative overflow-hidden rounded-t-2xl bg-gray-100 aspect-[3/2]">
                        <span
                            class="absolute top-3 left-3 bg-white/90 backdrop-blur-sm text-xs font-bold px-2 py-1 rounded-md text-gray-800 shadow-sm z-10">
                            {{ $product->category->name }}
                        </span>

                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition duration-500">

                    </div>

                    <div class="p-2 md:p-4 flex flex-col flex-grow">

                        <h3 class="text-sm font-bold text-gray-800 mb-2 leading-tight group-hover:text-blue-600 transition">
                            {{ $product->name }}
                        </h3>

                        <div class="mt-auto pt-2 border-t border-gray-100 flex items-center justify-between">
                            <div class="text-base font-bold text-blue-600">
                                {{ number_format($product->price) }} <span
                                    class="text-xs md:text-sm text-gray-500 font-normal">ကျပ်</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>

    <!-- Product Details Modal -->
    <div id="productModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 transition-opacity bg-gray-900 bg-opacity-75 backdrop-blur-sm" aria-hidden="true"
                onclick="closeProductModal()"></div>

            <!-- Center alignment trick -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <!-- Modal panel -->
            <div
                class="inline-block w-full max-w-2xl overflow-hidden text-left align-bottom transition-all transform bg-white rounded-2xl shadow-2xl sm:my-8 sm:align-middle">
                <div class="absolute top-0 right-0 pt-4 pr-4 z-10">
                    <button type="button" onclick="closeProductModal()"
                        class="text-gray-400 bg-white rounded-full p-1 hover:text-gray-500 hover:bg-gray-100 focus:outline-none transition">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2">
                    <!-- Product Image -->
                    <div class="relative h-48 sm:h-full bg-gray-100 flex items-center justify-center p-6">
                        <img id="modalImage" src="" alt="Product Image"
                            class="max-h-full max-w-full object-contain shadow-sm rounded-lg">
                    </div>

                    <!-- Product Details -->
                    <div class="p-6 flex flex-col">
                        <div class="mb-auto">
                            <span id="modalCategory"
                                class="inline-block px-3 py-1 mb-4 text-xs font-semibold tracking-wider text-blue-600 uppercase bg-blue-50 rounded-full border border-blue-100">
                                Category
                            </span>
                            <h2 id="modalTitle" class="mb-2 text-xl md:text-2xl font-bold text-gray-900 leading-tight">
                                Product Name
                            </h2>
                            <p class="mb-4 text-sm text-gray-500 font-mono">Code: <span id="modalCode"></span></p>

                            <div class="mb-4 md:mb-6">
                                <h3 class="font-bold text-gray-900 mb-2">Description</h3>
                                <p id="modalDescription" class="text-gray-600 leading-relaxed text-sm">
                                    <!-- Description will be loaded here -->
                                </p>
                            </div>
                            <div class="mb-4">
                                <h3 class="font-bold text-gray-900 mb-2">Variants</h3>
                                <div id="modalVariants" class="flex flex-wrap gap-2"></div>
                            </div>

                        </div>

                        <div class="flex items-center justify-between pt-6 border-t border-gray-100 mt-4">
                            <div>

                                <div class="text-1xl font-bold text-blue-600">
                                    <span id="modalPrice">0</span> <span
                                        class="text-1xl font-normal text-gray-500">ကျပ်</span>
                                </div>
                            </div>
                            <a id="modalAddToCart" href="#"
                                class="inline-flex items-center justify-center px-4 py-2 text-sm font-bold text-white transition-all duration-200 bg-blue-600 rounded-full shadow-lg hover:bg-blue-700 hover:shadow-xl transform hover:-translate-y-0.5 focus:ring-4 focus:ring-blue-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                အဝယ်စာရင်းထဲထည့်ပါ
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.productsData = @json($products);
        function openProductModal(element) {
            const modal = document.getElementById('productModal');
            const data = element.dataset;

            // Populate Modal Data
            document.getElementById('modalImage').src = data.image;
            document.getElementById('modalCategory').textContent = data.category;
            document.getElementById('modalTitle').textContent = data.name;
            document.getElementById('modalCode').textContent = data.code;
            document.getElementById('modalPrice').textContent = data.price;
            document.getElementById('modalAddToCart').href = data.addCartUrl;

            // Description
            document.getElementById('modalDescription').textContent = data.description || 'No description available.';

            // Variants
            let variants = [];
            if (window.productsData) {
                const currentId = parseInt(data.id);
                const currentProduct = window.productsData.find(p => p.id == currentId);
                if (currentProduct && currentProduct.variants && currentProduct.variants.length > 0) {
                    variants = currentProduct.variants;
                }
            }
            const variantsDiv = document.getElementById('modalVariants');
            variantsDiv.innerHTML = '';
            if (variants.length > 0) {
                variants.forEach(variant => {
                    const btn = document.createElement('button');
                    btn.className = 'px-3 py-1 rounded-lg border border-blue-300 bg-blue-50 text-blue-700 text-xs font-semibold hover:bg-blue-100 transition';
                    btn.textContent = variant.name + ' (' + variant.code_number + ')';
                    btn.onclick = function () {
                        const el = document.querySelector('[data-id="' + variant.id + '"]');
                        if (el) openProductModal(el);
                    };
                    variantsDiv.appendChild(btn);
                });
            } else {
                variantsDiv.innerHTML = '<span class="text-xs text-gray-400">No variants available.</span>';
            }
            // Show Modal
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Prevent background scrolling
        }

        function closeProductModal() {
            const modal = document.getElementById('productModal');
            modal.classList.add('hidden');
            document.body.style.overflow = ''; // Restore scrolling
        }

        // Close on Escape key
        document.addEventListener('keydown', function (event) {
            if (event.key === "Escape") {
                closeProductModal();
            }
        });
    </script>
@endsection