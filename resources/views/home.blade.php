@extends('layouts.master')

@section('content')
    @if (session('error'))
        <div class="sticky top-[73px] z-30 bg-red-500 px-4 py-3 text-center text-sm font-semibold text-white">
            {{ session('error') }}
        </div>
    @endif

    @php
        $heroSlides = $slides->count()
            ? $slides
            : collect([
                (object) [
                    'title' => 'Everyday deals for your home and gadgets',
                    'subtitle' => 'Just For You',
                    'description' => 'Browse popular products with a cleaner layout that is easy to scan and shop.',
                    'cta_label' => 'Shop Now',
                    'cta_link' => '#products-section',
                    'image_url' => 'https://placehold.co/1200x420/f97316/ffffff?text=DigitalMart+Deals',
                ],
            ]);
    @endphp

    <section class="bg-white">
        <div class="container mx-auto px-4 py-6">
            <div class="grid gap-4 lg:grid-cols-[minmax(0,1fr),280px]">
                <div class="relative overflow-hidden rounded-md border border-slate-200 bg-slate-100">
                    @foreach ($heroSlides as $slide)
                        <article
                            class="hero-slide relative min-h-[220px] {{ $loop->first ? 'block' : 'hidden' }}"
                            data-slide-index="{{ $loop->index }}">
                            <img src="{{ $slide->image_url }}" alt="{{ $slide->title }}"
                                class="absolute inset-0 h-full w-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-r from-slate-950/75 via-slate-950/45 to-transparent"></div>

                            <div class="relative z-10 flex min-h-[220px] flex-col justify-center px-6 py-8 text-white sm:px-8">
                                @if (!empty($slide->subtitle))
                                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-orange-200">
                                        {{ $slide->subtitle }}
                                    </p>
                                @endif
                                <h1 class="mt-3 max-w-xl text-3xl font-extrabold leading-tight sm:text-4xl">
                                    {{ $slide->title }}
                                </h1>
                                @if (!empty($slide->description))
                                    <p class="mt-3 max-w-lg text-sm text-slate-100 sm:text-base">
                                        {{ $slide->description }}
                                    </p>
                                @endif

                                <div class="mt-5 flex flex-wrap gap-3">
                                    <a href="{{ $slide->cta_link ?: '#products-section' }}"
                                        class="inline-flex items-center rounded-md bg-orange-500 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-orange-600">
                                        {{ $slide->cta_label ?: 'Shop Now' }}
                                    </a>
                                    <a href="{{ route('track_order') }}"
                                        class="inline-flex items-center rounded-md border border-white/40 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-white/10">
                                        Track Order
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach

                    @if ($heroSlides->count() > 1)
                        <div class="absolute bottom-4 left-6 z-20 flex gap-2">
                            @foreach ($heroSlides as $slide)
                                <button type="button"
                                    class="hero-dot h-2.5 rounded-full {{ $loop->first ? 'w-7 bg-white' : 'w-2.5 bg-white/60' }}"
                                    data-target-index="{{ $loop->index }}"
                                    aria-label="Go to slide {{ $loop->iteration }}"></button>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="grid gap-4 sm:grid-cols-3 lg:grid-cols-1">
                    <div class="rounded-md border border-slate-200 bg-white p-5">
                        <p class="text-sm font-semibold text-slate-500">Total Products</p>
                        <p class="mt-2 text-3xl font-extrabold text-slate-900">{{ $featuredProductsCount }}</p>
                    </div>
                    <div class="rounded-md border border-slate-200 bg-white p-5">
                        <p class="text-sm font-semibold text-slate-500">In Stock</p>
                        <p class="mt-2 text-3xl font-extrabold text-slate-900">{{ $inStockProductsCount }}</p>
                    </div>
                    <div class="rounded-md border border-slate-200 bg-white p-5">
                        <p class="text-sm font-semibold text-slate-500">Orders</p>
                        <p class="mt-2 text-3xl font-extrabold text-slate-900">{{ $totalOrdersCount }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="products-section" class="pb-12">
        <div class="container mx-auto px-4">
            <div class="rounded-md border border-slate-200 bg-white">
                <div class="border-b border-slate-200 px-4 py-4 sm:px-6">
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                        <div>
                            <p class="text-[15px] font-bold text-slate-900">
                                {{ $search ? 'Search Results' : 'Just For You' }}
                            </p>
                            <p class="mt-1 text-sm text-slate-500">
                                {{ $search ? $products->total() . ' products found for "' . $search . '"' : 'Simple product list for easy browsing.' }}
                            </p>
                        </div>
                        <div class="flex flex-wrap gap-3">
                            @if ($search)
                                <a href="{{ route('home') }}"
                                    class="inline-flex items-center rounded-md border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
                                    Clear Search
                                </a>
                            @endif
                            <a href="{{ route('cart.index') }}"
                                class="inline-flex items-center rounded-md bg-slate-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-slate-800">
                                View Cart
                            </a>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3 p-3 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6">
                    @foreach ($products as $product)
                        <article
                            class="group overflow-hidden rounded-md border border-slate-200 bg-white transition hover:border-slate-300 hover:shadow-md {{ $product->stock > 0 ? 'cursor-pointer' : 'opacity-80' }}"
                            onclick="{{ $product->stock > 0 ? 'openProductModal(this)' : '' }}" data-id="{{ $product->id }}"
                            data-name="{{ $product->name }}" data-price="{{ number_format($product->price) }}"
                            data-image="{{ asset('storage/' . $product->image) }}" data-category="{{ $product->category->name }}"
                            data-code="{{ $product->code_number }}" data-add-cart-url="{{ route('add_to_cart', $product->id) }}"
                            data-description="{{ $product->description }}" data-stock="{{ $product->stock }}">
                            <div class="relative aspect-square overflow-hidden bg-slate-100">
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                    class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
                                @if ($product->stock <= 0)
                                    <span class="absolute right-2 top-2 rounded bg-red-500 px-2 py-1 text-[10px] font-bold uppercase text-white">
                                        Out
                                    </span>
                                @elseif ($product->stock <= 5)
                                    <span class="absolute right-2 top-2 rounded bg-amber-400 px-2 py-1 text-[10px] font-bold uppercase text-slate-900">
                                        {{ $product->stock }} left
                                    </span>
                                @endif
                            </div>

                            <div class="space-y-2 p-3">
                                <p class="text-[11px] text-slate-400">{{ $product->category->name }}</p>
                                <h3 class="min-h-[40px] text-sm font-semibold leading-5 text-slate-800">
                                    {{ \Illuminate\Support\Str::limit($product->name, 46) }}
                                </h3>
                                <p class="text-[11px] text-slate-400">{{ $product->code_number }}</p>

                                @if ($product->stock > 0)
                                    <div class="flex items-end justify-between gap-2 pt-1">
                                        <div>
                                            <p class="text-lg font-extrabold text-orange-600">{{ number_format($product->price) }}</p>
                                            <p class="text-[11px] uppercase text-slate-400">MMK</p>
                                        </div>
                                        <button type="button" onclick="event.stopPropagation(); quickView({{ $product->id }})"
                                            class="inline-flex h-9 w-9 items-center justify-center rounded-md bg-orange-500 text-white transition hover:bg-orange-600">
                                            <i class="fa-solid fa-plus text-xs"></i>
                                        </button>
                                    </div>
                                @else
                                    <p class="pt-1 text-sm font-semibold text-red-500">Out of stock</p>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="border-t border-slate-200 px-4 py-5">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </section>

    <div id="productModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/60" onclick="closeProductModal()"></div>

        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4">
                <div class="relative w-full max-w-4xl scale-95 rounded-2xl bg-white opacity-0 shadow-2xl transition-all duration-300"
                    id="modalPanel">
                    <button type="button" onclick="closeProductModal()"
                        class="absolute right-4 top-4 z-20 rounded-full bg-white p-2 text-slate-500 shadow-sm transition hover:text-slate-900">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <div class="grid grid-cols-1 md:grid-cols-2">
                        <div class="relative flex items-center justify-center bg-slate-100 p-8 md:min-h-[460px]">
                            <img id="modalImage" src="" alt="Product Image"
                                class="max-h-[360px] max-w-full rounded-xl object-contain">
                            <span id="modalStockBadge"
                                class="absolute left-4 top-4 hidden rounded px-3 py-1 text-sm font-bold"></span>
                        </div>

                        <div class="flex flex-col p-8">
                            <div class="mb-auto space-y-4">
                                <span id="modalCategory"
                                    class="inline-flex rounded bg-slate-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.18em] text-slate-600"></span>

                                <h2 id="modalTitle" class="text-2xl font-bold leading-tight text-slate-900"></h2>

                                <p class="inline-block rounded bg-slate-100 px-3 py-1 text-sm text-slate-500">
                                    Code: <span id="modalCode"></span>
                                </p>

                                <div class="border-y border-slate-200 py-4">
                                    <div class="flex items-end gap-2">
                                        <span id="modalPrice" class="text-3xl font-extrabold text-orange-600"></span>
                                        <span class="text-slate-500">ကျပ်</span>
                                    </div>
                                </div>

                                <div>
                                    <h3 class="mb-2 text-sm font-semibold text-slate-900">Description</h3>
                                    <p id="modalDescription" class="text-sm leading-7 text-slate-600"></p>
                                </div>

                                <div>
                                    <h3 class="mb-3 text-sm font-semibold text-slate-900">Available Variants</h3>
                                    <div id="modalVariants" class="flex flex-wrap gap-2"></div>
                                </div>
                            </div>

                            <div class="mt-6 flex items-center gap-4 border-t border-slate-200 pt-6">
                                <a id="modalAddToCart" href="#"
                                    class="inline-flex flex-1 items-center justify-center rounded-md bg-orange-500 px-6 py-3 text-sm font-semibold text-white transition hover:bg-orange-600">
                                    Add to Cart
                                </a>
                                <button type="button" onclick="addToWishlist()"
                                    class="rounded-md border border-slate-300 px-4 py-3 text-slate-500 transition hover:bg-slate-50 hover:text-slate-700">
                                    <i class="fa-regular fa-heart"></i>
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
                stockBadge.className = 'absolute left-4 top-4 rounded bg-red-500 px-3 py-1 text-sm font-bold text-white';
                stockBadge.classList.remove('hidden');
            } else if (parseInt(data.stock) <= 5) {
                stockBadge.textContent = `Only ${data.stock} left`;
                stockBadge.className = 'absolute left-4 top-4 rounded bg-amber-400 px-3 py-1 text-sm font-bold text-slate-900';
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
                    btn.className = 'rounded border border-slate-300 px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50';
                    btn.textContent = `${variant.name} (${variant.code_number})`;
                    btn.onclick = function() {
                        const el = document.querySelector(`[data-id="${variant.id}"]`);
                        if (el) {
                            openProductModal(el);
                        }
                    };
                    variantsDiv.appendChild(btn);
                });
            } else {
                variantsDiv.innerHTML = '<span class="text-sm text-slate-400">No other variants available</span>';
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
            }, 200);
        }

        function addToWishlist() {
            return;
        }

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeProductModal();
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const slides = Array.from(document.querySelectorAll('.hero-slide'));
            const dots = Array.from(document.querySelectorAll('.hero-dot'));

            if (!slides.length || slides.length === 1) {
                return;
            }

            let activeIndex = 0;

            const renderSlide = (nextIndex) => {
                slides.forEach((slide, index) => {
                    slide.classList.toggle('hidden', index !== nextIndex);
                });

                dots.forEach((dot, index) => {
                    dot.classList.toggle('w-7', index === nextIndex);
                    dot.classList.toggle('bg-white', index === nextIndex);
                    dot.classList.toggle('w-2.5', index !== nextIndex);
                    dot.classList.toggle('bg-white/60', index !== nextIndex);
                });

                activeIndex = nextIndex;
            };

            dots.forEach((dot, index) => {
                dot.addEventListener('click', () => renderSlide(index));
            });

            setInterval(() => {
                renderSlide((activeIndex + 1) % slides.length);
            }, 5000);
        });
    </script>
@endsection
