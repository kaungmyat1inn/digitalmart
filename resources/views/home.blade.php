@extends('layouts.master')

@section('content')
    @if (session('error'))
        <div class="bg-red-500 text-white p-4 text-center font-bold sticky top-20 z-50 shadow-lg">
            {{ session('error') }}
        </div>
    @endif

    @php
        $heroSlides = $slides->count()
            ? $slides
            : collect([
                (object) [
                    'title' => 'Fresh tech drops for your digital lifestyle',
                    'subtitle' => 'DigitalMart Weekly Picks',
                    'description' => 'Run the shop with a living promotion carousel. Add your own campaign images, flash sales, and launch banners from the admin panel.',
                    'cta_label' => 'Shop Collection',
                    'cta_link' => '#products-section',
                    'image_url' => 'https://placehold.co/1200x720/png?text=DigitalMart+Promotion',
                ],
            ]);
    @endphp

    <section class="relative overflow-hidden bg-[#f4efe8]">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,_rgba(180,83,9,0.18),_transparent_38%),radial-gradient(circle_at_bottom_right,_rgba(14,116,144,0.18),_transparent_36%)]"></div>

        <div class="relative container mx-auto px-4 pt-8 pb-12 md:pt-10 md:pb-16">
            <div class="grid grid-cols-1 xl:grid-cols-[minmax(0,1.2fr),360px] gap-6 items-stretch">
                <div class="relative overflow-hidden rounded-[2rem] bg-[#1c1917] text-white shadow-[0_30px_80px_-30px_rgba(28,25,23,0.7)]">
                    <div class="absolute inset-0 bg-gradient-to-r from-[#111827]/90 via-[#111827]/65 to-[#0f766e]/50"></div>
                    <div class="absolute inset-0">
                        @foreach ($heroSlides as $slide)
                            <article
                                class="hero-slide absolute inset-0 {{ $loop->first ? 'opacity-100' : 'opacity-0 pointer-events-none' }}"
                                data-slide-index="{{ $loop->index }}">
                                <img src="{{ $slide->image_url }}" alt="{{ $slide->title }}"
                                    class="absolute inset-0 h-full w-full object-cover">
                                <div class="absolute inset-0 bg-gradient-to-r from-[#111827]/90 via-[#111827]/65 to-transparent"></div>
                                <div class="relative z-10 flex h-full flex-col justify-between p-6 sm:p-8 lg:p-10">
                                    <div class="max-w-2xl">
                                        @if (!empty($slide->subtitle))
                                            <span
                                                class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.3em] text-amber-200 backdrop-blur">
                                                <span class="h-2 w-2 rounded-full bg-amber-300"></span>
                                                {{ $slide->subtitle }}
                                            </span>
                                        @endif

                                        <h1 class="mt-6 max-w-2xl text-4xl font-black leading-tight sm:text-5xl lg:text-6xl">
                                            {{ $slide->title }}
                                        </h1>
                                        @if (!empty($slide->description))
                                            <p class="mt-5 max-w-xl text-sm leading-7 text-stone-200 sm:text-base">
                                                {{ $slide->description }}
                                            </p>
                                        @endif

                                        <div class="mt-8 flex flex-wrap gap-3">
                                            <a href="{{ $slide->cta_link ?: '#products-section' }}"
                                                class="inline-flex items-center gap-2 rounded-full bg-[#f59e0b] px-6 py-3 text-sm font-bold text-stone-950 transition hover:bg-[#fbbf24]">
                                                {{ $slide->cta_label ?: 'Shop Now' }}
                                                <i class="fas fa-arrow-right text-xs"></i>
                                            </a>
                                            <a href="{{ route('track_order') }}"
                                                class="inline-flex items-center gap-2 rounded-full border border-white/25 bg-white/10 px-6 py-3 text-sm font-semibold text-white backdrop-blur transition hover:bg-white/20">
                                                Track Order
                                            </a>
                                        </div>
                                    </div>

                                    <div class="mt-8 flex flex-wrap gap-3 text-xs text-stone-200 sm:text-sm">
                                        <div class="rounded-2xl border border-white/10 bg-white/10 px-4 py-3 backdrop-blur">
                                            <div class="text-2xl font-black text-white">{{ $featuredProductsCount }}+</div>
                                            <div>Curated gadgets</div>
                                        </div>
                                        <div class="rounded-2xl border border-white/10 bg-white/10 px-4 py-3 backdrop-blur">
                                            <div class="text-2xl font-black text-white">{{ $inStockProductsCount }}+</div>
                                            <div>Ready to ship</div>
                                        </div>
                                        <div class="rounded-2xl border border-white/10 bg-white/10 px-4 py-3 backdrop-blur">
                                            <div class="text-2xl font-black text-white">{{ $totalOrdersCount }}+</div>
                                            <div>Orders fulfilled</div>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    @if ($heroSlides->count() > 1)
                        <button type="button" id="hero-prev"
                            class="absolute left-4 top-1/2 z-20 -translate-y-1/2 rounded-full border border-white/20 bg-black/25 px-4 py-3 text-white backdrop-blur transition hover:bg-black/40">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button type="button" id="hero-next"
                            class="absolute right-4 top-1/2 z-20 -translate-y-1/2 rounded-full border border-white/20 bg-black/25 px-4 py-3 text-white backdrop-blur transition hover:bg-black/40">
                            <i class="fas fa-chevron-right"></i>
                        </button>

                        <div class="absolute bottom-5 left-6 z-20 flex gap-2">
                            @foreach ($heroSlides as $slide)
                                <button type="button"
                                    class="hero-dot h-2.5 rounded-full bg-white/40 transition-all {{ $loop->first ? 'w-10 bg-white' : 'w-2.5' }}"
                                    data-target-index="{{ $loop->index }}"
                                    aria-label="Go to slide {{ $loop->iteration }}"></button>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="grid gap-6">
                    <div class="rounded-[2rem] bg-white p-6 shadow-[0_20px_50px_-30px_rgba(15,23,42,0.45)] ring-1 ring-black/5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-bold uppercase tracking-[0.25em] text-cyan-700">Store Highlights</p>
                                <h2 class="mt-2 text-2xl font-black text-stone-900">Fast-moving deals</h2>
                            </div>
                            <div class="rounded-2xl bg-cyan-50 p-4 text-cyan-700">
                                <i class="fas fa-bolt text-xl"></i>
                            </div>
                        </div>
                        <div class="mt-6 space-y-4">
                            <div class="rounded-2xl bg-stone-50 p-4">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-semibold text-stone-600">In-stock picks</span>
                                    <span class="text-lg font-black text-stone-900">{{ $inStockProductsCount }}</span>
                                </div>
                                <div class="mt-3 h-2 rounded-full bg-stone-200">
                                    <div class="h-2 rounded-full bg-gradient-to-r from-cyan-600 to-emerald-500" style="width: {{ min(100, max(18, $featuredProductsCount > 0 ? ($inStockProductsCount / max($featuredProductsCount, 1)) * 100 : 18)) }}%"></div>
                                </div>
                            </div>
                            <div class="rounded-2xl bg-stone-900 p-5 text-white">
                                <p class="text-sm text-stone-300">Need help before ordering?</p>
                                <p class="mt-2 text-xl font-black">Track shipments and manage checkout in seconds.</p>
                                <a href="{{ route('track_order') }}" class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-amber-300">
                                    Open tracking
                                    <i class="fas fa-arrow-right text-xs"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-[2rem] bg-[#0f766e] p-6 text-white shadow-[0_20px_50px_-30px_rgba(15,118,110,0.65)]">
                        <p class="text-xs font-bold uppercase tracking-[0.25em] text-teal-100">Admin Controlled</p>
                        <h3 class="mt-3 text-2xl font-black">Promotion photos can now be updated from the dashboard.</h3>
                        <p class="mt-3 text-sm leading-7 text-teal-50">Upload images, change headlines, hide old campaigns, and reorder slides from the new Promotions section.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="products-section" class="bg-[#fffaf5] py-14 sm:py-16">
        <div class="container mx-auto px-4">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.3em] text-amber-700">
                        {{ $search ? 'Search Results' : 'Shop Floor' }}
                    </p>
                    <h2 class="mt-3 text-3xl font-black text-stone-900 sm:text-4xl">
                        {{ $search ? 'Products matching "' . $search . '"' : 'Popular products worth opening first' }}
                    </h2>
                    <p class="mt-3 max-w-2xl text-sm leading-7 text-stone-600 sm:text-base">
                        {{ $search ? $products->total() . ' results found for your search.' : 'A cleaner storefront with quicker scanning, better product focus, and stronger promotional storytelling at the top of the page.' }}
                    </p>
                </div>

                <div class="flex flex-wrap gap-3">
                    @if ($search)
                        <a href="{{ route('home') }}"
                            class="inline-flex items-center gap-2 rounded-full border border-stone-300 px-5 py-3 text-sm font-semibold text-stone-700 transition hover:border-stone-900 hover:text-stone-900">
                            Clear Search
                        </a>
                    @endif
                    <a href="{{ route('cart.index') }}"
                        class="inline-flex items-center gap-2 rounded-full bg-stone-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-stone-700">
                        View Cart
                        <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </div>
            </div>

            <div class="mt-10 grid grid-cols-2 gap-4 md:grid-cols-3 xl:grid-cols-5">
                @foreach ($products as $product)
                    <article
                        class="group overflow-hidden rounded-[1.75rem] border border-stone-200 bg-white shadow-[0_18px_45px_-28px_rgba(15,23,42,0.38)] transition duration-500 hover:-translate-y-2 hover:shadow-[0_28px_70px_-30px_rgba(15,23,42,0.45)] {{ $product->stock > 0 ? 'cursor-pointer' : 'opacity-80' }}"
                        onclick="{{ $product->stock > 0 ? 'openProductModal(this)' : '' }}" data-id="{{ $product->id }}"
                        data-name="{{ $product->name }}" data-price="{{ number_format($product->price) }}"
                        data-image="{{ asset('storage/' . $product->image) }}" data-category="{{ $product->category->name }}"
                        data-code="{{ $product->code_number }}" data-add-cart-url="{{ route('add_to_cart', $product->id) }}"
                        data-description="{{ $product->description }}" data-stock="{{ $product->stock }}">
                        <div class="relative aspect-[4/4.3] overflow-hidden bg-[#f5f5f4]">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                class="h-full w-full object-cover transition duration-700 group-hover:scale-110">
                            <div class="absolute inset-x-0 top-0 flex items-start justify-between p-3">
                                <span class="rounded-full bg-white/90 px-3 py-1 text-[11px] font-bold uppercase tracking-[0.2em] text-stone-700 backdrop-blur">
                                    {{ $product->category->name }}
                                </span>
                                @if ($product->stock <= 0)
                                    <span class="rounded-full bg-red-500 px-3 py-1 text-[11px] font-bold uppercase tracking-[0.15em] text-white">
                                        Out
                                    </span>
                                @elseif ($product->stock <= 5)
                                    <span class="rounded-full bg-amber-400 px-3 py-1 text-[11px] font-bold uppercase tracking-[0.15em] text-stone-900">
                                        {{ $product->stock }} left
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="space-y-4 p-4 sm:p-5">
                            <div>
                                <p class="text-[11px] font-bold uppercase tracking-[0.25em] text-stone-400">{{ $product->code_number }}</p>
                                <h3 class="mt-2 line-clamp-2 text-sm font-bold leading-6 text-stone-900 sm:text-base">
                                    {{ $product->name }}
                                </h3>
                            </div>

                            <div class="flex items-end justify-between gap-3">
                                @if ($product->stock > 0)
                                    <div>
                                        <div class="text-xl font-black text-stone-900">{{ number_format($product->price) }}</div>
                                        <div class="text-xs font-medium uppercase tracking-[0.2em] text-stone-400">MMK</div>
                                    </div>
                                    <button type="button" onclick="event.stopPropagation(); quickView({{ $product->id }})"
                                        class="inline-flex h-11 w-11 items-center justify-center rounded-full bg-[#0f766e] text-white transition hover:bg-[#115e59]">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                @else
                                    <div class="text-sm font-bold text-red-500">Out of stock</div>
                                @endif
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-12">
                {{ $products->links() }}
            </div>
        </div>
    </section>

    <div id="productModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="closeProductModal()"></div>

        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4">
                <div class="relative w-full max-w-4xl bg-white rounded-3xl shadow-2xl transform transition-all duration-500 scale-95 opacity-0"
                    id="modalPanel">
                    <button type="button" onclick="closeProductModal()"
                        class="absolute top-4 right-4 z-20 bg-white/80 hover:bg-white text-gray-500 hover:text-gray-700 rounded-full p-2 shadow-lg transition-all duration-300 hover:scale-110">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <div class="grid grid-cols-1 md:grid-cols-2">
                        <div class="relative bg-gradient-to-br from-gray-100 to-gray-200 p-8 md:min-h-[500px] flex items-center justify-center">
                            <img id="modalImage" src="" alt="Product Image"
                                class="max-w-full max-h-[400px] object-contain rounded-2xl shadow-lg transform transition-transform duration-500 hover:scale-105">
                            <span id="modalStockBadge"
                                class="absolute top-4 left-4 px-3 py-1 rounded-full text-sm font-bold hidden"></span>
                        </div>

                        <div class="p-8 flex flex-col">
                            <div class="mb-auto space-y-4">
                                <span id="modalCategory"
                                    class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold tracking-wider uppercase bg-blue-100 text-blue-700"></span>

                                <h2 id="modalTitle" class="text-2xl md:text-3xl font-bold text-gray-900 leading-tight"></h2>

                                <p class="text-sm text-gray-500 font-mono bg-gray-100 inline-block px-3 py-1 rounded-lg">
                                    Code: <span id="modalCode"></span>
                                </p>

                                <div class="py-4 border-y border-gray-100">
                                    <div class="flex items-baseline gap-2">
                                        <span id="modalPrice" class="text-3xl font-bold text-blue-600"></span>
                                        <span class="text-gray-500 text-lg">ကျပ်</span>
                                    </div>
                                </div>

                                <div>
                                    <h3 class="font-bold text-gray-900 mb-2">Description</h3>
                                    <p id="modalDescription" class="text-gray-600 leading-relaxed"></p>
                                </div>

                                <div>
                                    <h3 class="font-bold text-gray-900 mb-3">Available Variants</h3>
                                    <div id="modalVariants" class="flex flex-wrap gap-2"></div>
                                </div>
                            </div>

                            <div class="flex items-center gap-4 pt-6 mt-6 border-t border-gray-100">
                                <a id="modalAddToCart" href="#"
                                    class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-3 text-sm font-bold text-white bg-gradient-to-r from-blue-500 to-blue-600 rounded-full shadow-lg hover:from-blue-600 hover:to-blue-700 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
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
        const getCurrentProducts = () => @json($products->items());

        function quickView(productId) {
            const product = document.querySelector(`[data-id="${productId}"]`);
            if (product) openProductModal(product);
        }

        function openProductModal(element) {
            const modal = document.getElementById('productModal');
            const modalPanel = document.getElementById('modalPanel');
            const data = element.dataset;

            document.getElementById('modalImage').src = data.image;
            document.getElementById('modalCategory').textContent = data.category;
            document.getElementById('modalTitle').textContent = data.name;
            document.getElementById('modalCode').textContent = data.code;
            document.getElementById('modalPrice').textContent = data.price;
            document.getElementById('modalAddToCart').href = data.addCartUrl;
            document.getElementById('modalDescription').textContent = data.description || 'No description available.';

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
                        const el = document.querySelector(`[data-id="${variant.id}"]`);
                        if (el) {
                            openProductModal(el);
                        }
                    };
                    variantsDiv.appendChild(btn);
                });
            } else {
                variantsDiv.innerHTML = '<span class="text-sm text-gray-400 italic">No other variants available</span>';
            }

            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';

            setTimeout(() => {
                modalPanel.classList.remove('scale-95', 'opacity-0');
                modalPanel.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeProductModal() {
            const modal = document.getElementById('productModal');
            const modalPanel = document.getElementById('modalPanel');

            modalPanel.classList.remove('scale-100', 'opacity-100');
            modalPanel.classList.add('scale-95', 'opacity-0');

            setTimeout(() => {
                modal.classList.add('hidden');
                document.body.style.overflow = '';
            }, 300);
        }

        function addToWishlist() {
            return;
        }

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeProductModal();
            }
        });

        document.addEventListener('DOMContentLoaded', function () {
            const slides = Array.from(document.querySelectorAll('.hero-slide'));
            const dots = Array.from(document.querySelectorAll('.hero-dot'));
            const prevButton = document.getElementById('hero-prev');
            const nextButton = document.getElementById('hero-next');

            if (!slides.length) {
                return;
            }

            let activeIndex = 0;
            let intervalId = null;

            const renderSlide = (nextIndex) => {
                slides.forEach((slide, index) => {
                    const isActive = index === nextIndex;
                    slide.classList.toggle('opacity-100', isActive);
                    slide.classList.toggle('opacity-0', !isActive);
                    slide.classList.toggle('pointer-events-none', !isActive);
                });

                dots.forEach((dot, index) => {
                    dot.classList.toggle('w-10', index === nextIndex);
                    dot.classList.toggle('bg-white', index === nextIndex);
                    dot.classList.toggle('w-2.5', index !== nextIndex);
                    dot.classList.toggle('bg-white/40', index !== nextIndex);
                });

                activeIndex = nextIndex;
            };

            const nextSlide = () => renderSlide((activeIndex + 1) % slides.length);
            const prevSlide = () => renderSlide((activeIndex - 1 + slides.length) % slides.length);

            const startAutoplay = () => {
                if (slides.length <= 1) {
                    return;
                }

                clearInterval(intervalId);
                intervalId = setInterval(nextSlide, 5000);
            };

            prevButton?.addEventListener('click', () => {
                prevSlide();
                startAutoplay();
            });

            nextButton?.addEventListener('click', () => {
                nextSlide();
                startAutoplay();
            });

            dots.forEach((dot, index) => {
                dot.addEventListener('click', () => {
                    renderSlide(index);
                    startAutoplay();
                });
            });

            startAutoplay();
        });
    </script>
@endsection
