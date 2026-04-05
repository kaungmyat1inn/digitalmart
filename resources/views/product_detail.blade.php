@extends('layouts.master')

@section('content')
    <section class="py-8">
        <div class="container mx-auto px-4">
            <div class="mb-5">
                <a href="{{ route('home') }}" class="text-sm text-slate-500 transition hover:text-slate-900">
                    Home
                </a>
                <span class="mx-2 text-slate-300">/</span>
                <span class="text-sm text-slate-700">{{ $product->name }}</span>
            </div>

            <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">
                <div class="grid gap-0 md:grid-cols-2">
                    <div class="flex items-center justify-center bg-slate-100 p-8">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                            class="max-h-[420px] max-w-full rounded-lg object-contain">
                    </div>

                    <div class="p-6 sm:p-8">
                        <p class="text-sm font-medium text-slate-500">{{ $product->category->name ?? '-' }}</p>
                        <h1 class="mt-2 text-3xl font-extrabold leading-tight text-slate-900">{{ $product->name }}</h1>
                        <p class="mt-3 text-sm text-slate-500">Code: {{ $product->code_number }}</p>

                        <div class="mt-6 border-y border-slate-200 py-5">
                            <p class="text-3xl font-extrabold text-orange-600">{{ number_format($product->price) }} MMK</p>
                            @if ($product->stock > 0)
                                <p class="mt-2 text-sm font-medium text-emerald-600">In stock: {{ $product->stock }}</p>
                            @else
                                <p class="mt-2 text-sm font-medium text-red-500">Out of stock</p>
                            @endif
                        </div>

                        <div class="mt-6">
                            <h2 class="text-sm font-semibold uppercase tracking-[0.15em] text-slate-500">Description</h2>
                            <p class="mt-3 text-sm leading-7 text-slate-600">
                                {{ $product->description ?: 'No description available for this product.' }}
                            </p>
                        </div>

                        @if ($product->variants->isNotEmpty())
                            <div class="mt-6">
                                <h2 class="text-sm font-semibold uppercase tracking-[0.15em] text-slate-500">Variants</h2>
                                <div class="mt-3 flex flex-wrap gap-2">
                                    @foreach ($product->variants as $variant)
                                        <a href="{{ route('products.show', ['product' => $variant->id, 'slug' => \Illuminate\Support\Str::of($variant->name)->replace(' ', '_')->slug('_')]) }}"
                                            class="rounded-md border border-slate-300 px-3 py-2 text-sm text-slate-700 transition hover:bg-slate-50">
                                            {{ $variant->name }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="mt-8 flex flex-wrap gap-3">
                            @if ($product->stock > 0)
                                <a href="{{ route('add_to_cart', $product->id) }}"
                                    class="inline-flex items-center rounded-md bg-orange-500 px-5 py-3 text-sm font-semibold text-white transition hover:bg-orange-600">
                                    Add to Cart
                                </a>
                            @endif
                            <a href="{{ route('home') }}"
                                class="inline-flex items-center rounded-md border border-slate-300 px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                                Back to Home
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
