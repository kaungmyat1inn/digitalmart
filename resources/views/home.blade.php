@extends('layouts.master')

@section('content')
    @php
        $productSlug = fn ($name) => \Illuminate\Support\Str::of($name)->replace(' ', '_')->slug('_');
    @endphp

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
        </div>
    </section>

    <section id="products-section" class="pb-12">
        <div class="container mx-auto px-4">
            <div class="rounded-md border border-slate-200 bg-white">
                <div class="border-b border-slate-200 px-4 py-4 sm:px-6">
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                        <div>
                            <p class="text-[15px] font-bold text-slate-900">
                                {{ $search ? 'Search Results' : $homepageSettings->just_for_you_title }}
                            </p>
                            <p class="mt-1 text-sm text-slate-500">
                                {{ $search ? $products->total() . ' products found for "' . $search . '"' : $homepageSettings->just_for_you_subtitle }}
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
                        @php
                            $detailUrl = route('products.show', ['product' => $product->id, 'slug' => $productSlug($product->name)]);
                        @endphp
                        <article
                            class="group overflow-hidden rounded-md border border-slate-200 bg-white transition hover:border-slate-300 hover:shadow-md {{ $product->stock > 0 ? '' : 'opacity-80' }}">
                            <div class="relative aspect-square overflow-hidden bg-slate-100">
                                <a href="{{ $detailUrl }}" class="block h-full w-full">
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                        class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
                                </a>
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
                                <a href="{{ $detailUrl }}" class="block min-h-[40px] text-sm font-semibold leading-5 text-slate-800 transition hover:text-orange-600">
                                    {{ \Illuminate\Support\Str::limit($product->name, 46) }}
                                </a>
                                <p class="text-[11px] text-slate-400">{{ $product->code_number }}</p>

                                @if ($product->stock > 0)
                                    <div class="flex items-end justify-between gap-2 pt-1">
                                        <div>
                                            <p class="text-lg font-extrabold text-orange-600">{{ number_format($product->price) }}</p>
                                            <p class="text-[11px] uppercase text-slate-400">MMK</p>
                                        </div>
                                        <a href="{{ $detailUrl }}"
                                            class="inline-flex h-9 items-center justify-center rounded-md border border-slate-300 px-3 text-xs font-semibold text-slate-700 transition hover:bg-slate-50">
                                            Details
                                        </a>
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

    <script>
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
