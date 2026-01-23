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

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @foreach ($products as $product)
                <div
                    class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 group border border-gray-100 flex flex-col h-full">

                    <div class="relative h-60 overflow-hidden rounded-t-2xl bg-gray-100">
                        <span
                            class="absolute top-3 left-3 bg-white/90 backdrop-blur-sm text-xs font-bold px-2 py-1 rounded-md text-gray-800 shadow-sm z-10">
                            {{ $product->category->name }}
                        </span>

                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition duration-500">

                        <div
                            class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300">
                            <button
                                class="bg-white text-gray-900 px-6 py-2 rounded-full font-bold hover:bg-blue-600 hover:text-white transition transform translate-y-4 group-hover:translate-y-0">
                                View Details
                            </button>
                        </div>
                    </div>

                    <div class="p-5 flex flex-col flex-grow">
                        <p class="text-xs text-gray-500 mb-1 font-medium">{{ $product->code_number }}</p>
                        <h3 class="text-lg font-bold text-gray-800 mb-2 leading-tight group-hover:text-blue-600 transition">
                            {{ $product->name }}
                        </h3>

                        <div class="mt-auto flex items-center justify-between pt-4 border-t border-gray-50">
                            <span class="text-xl font-bold text-blue-600">
                                {{ number_format($product->price) }} <span class="text-sm text-gray-500 font-normal">ကျပ်</span>
                            </span>

                            <a href="{{ route('add_to_cart', $product->id) }}"
                                class="block w-full text-center mt-4 bg-gray-100 hover:bg-blue-600 hover:text-white text-gray-700 font-medium py-2 rounded transition shadow-sm">
                                ခြင်းထဲထည့်ပါ
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
@endsection