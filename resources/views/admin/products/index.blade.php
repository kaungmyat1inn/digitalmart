@extends('layouts.admin')

@section('title', 'Products Management')

@section('content')
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">

        <div class="p-6 border-b border-gray-100 dark:border-gray-700">
            
            {{-- Header Title & Actions --}}
            <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
                <div class="flex items-center gap-3">
                    <h3 class="font-bold text-gray-800 dark:text-white text-lg">Product List</h3>
                    <span class="px-3 py-1 bg-blue-100 text-blue-600 rounded-full text-xs font-bold">
                        Total: {{ $products->total() }}
                    </span>
                </div>

                <div class="flex gap-3 w-full md:w-auto">
                    {{-- Search Form --}}
                    <form action="{{ route('admin.products.index') }}" method="GET" class="w-full md:w-auto flex-1">
                        {{-- Category မပျောက်သွားအောင် Hidden Input --}}
                        <input type="hidden" name="category" value="{{ request('category') }}">

                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}"
                                class="block w-full md:w-64 p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                                placeholder="Search Name or Code...">
                        </div>
                    </form>

                    {{-- Add New Button --}}
                    <a href="{{ route('admin.products.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow transition flex items-center gap-2 whitespace-nowrap">
                        <i class="fas fa-plus"></i> <span class="hidden sm:inline">Add New</span>
                    </a>
                </div>
            </div>

            {{-- Category Filter Tabs --}}
            <div class="overflow-x-auto no-scrollbar">
                <div class="flex space-x-2 min-w-max pb-2">
                    
                    {{-- Helper Function for Active Class --}}
                    @php
                        $currentCat = request('category');
                        function getCatTabClass($id, $current) {
                            $base = "px-4 py-2 rounded-lg text-sm font-bold transition flex items-center gap-2 border ";
                            if($id == $current) {
                                return $base . "bg-blue-600 text-white border-blue-600 shadow-md"; 
                            }
                            return $base . "bg-gray-50 text-gray-600 border-gray-200 hover:bg-gray-100 hover:text-blue-600 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600";
                        }
                    @endphp

                    {{-- 1. All Products Tab --}}
                    <a href="{{ route('admin.products.index', ['search' => request('search')]) }}" 
                       class="{{ getCatTabClass(null, $currentCat) }}">
                        All
                    </a>

                    {{-- 2. Dynamic Categories Tabs --}}
                    @foreach($categories as $category)
                        <a href="{{ route('admin.products.index', ['category' => $category->id, 'search' => request('search')]) }}" 
                           class="{{ getCatTabClass($category->id, $currentCat) }}">
                            {{ $category->name }}
                            <span class="py-0.5 px-2 rounded-full text-xs ml-1 {{ $currentCat == $category->id ? 'bg-white text-blue-600' : 'bg-gray-200 text-gray-600' }}">
                                {{ $category->products_count }}
                            </span>
                        </a>
                    @endforeach

                </div>
            </div>
        </div>

        {{-- Table Content --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 dark:bg-gray-700 text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Product</th>
                        <th class="px-6 py-4 font-semibold">Category</th>
                        <th class="px-6 py-4 font-semibold">Supplier</th>
                        <th class="px-6 py-4 font-semibold">Price</th>
                        <th class="px-6 py-4 font-semibold text-center">Stock</th>
                        <th class="px-6 py-4 font-semibold text-center">Status</th>
                        <th class="px-6 py-4 font-semibold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700 text-sm text-gray-700 dark:text-gray-300">
                    @forelse($products as $product)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150">
                            {{-- Product Name & Image --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-12 w-12 rounded bg-gray-100 dark:bg-gray-700 flex-shrink-0 overflow-hidden flex items-center justify-center border border-gray-200 dark:border-gray-600">
                                        @if ($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" class="h-full w-full object-cover">
                                        @else
                                            <i class="fas fa-image text-gray-400"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-800 dark:text-white">{{ $product->name }}</p>
                                        <p class="text-xs text-blue-500 font-bold">{{ $product->code_number }}</p>
                                    </div>
                                </div>
                            </td>

                            {{-- Category --}}
                            <td class="px-6 py-4">
                                <span class="bg-gray-100 text-gray-600 py-1 px-3 rounded-full text-xs font-bold dark:bg-gray-600 dark:text-gray-300">
                                    {{ $product->category->name ?? 'Uncategorized' }}
                                </span>
                            </td>

                            {{-- Supplier --}}
                            <td class="px-6 py-4">
                                {{ $product->supplier ?? 'N/A' }}
                            </td>

                            {{-- Price --}}
                            <td class="px-6 py-4 font-bold text-gray-800 dark:text-gray-200">
                                {{ number_format($product->price) }} Ks
                            </td>

                            {{-- Stock --}}
                            <td class="px-6 py-4 text-center">
                                <span class="font-mono text-base">{{ $product->stock }}</span>
                                @if($product->stock > 0)
                                    <span class="ml-2 text-green-600 bg-green-100 py-1 px-2 rounded-full text-xs font-bold">In Stock</span>
                                @else
                                    <span class="ml-2 text-red-600 bg-red-100 py-1 px-2 rounded-full text-xs font-bold">Out of Stock</span>
                                @endif
                            </td>

                            {{-- Actions --}}
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="p-2 bg-yellow-50 text-yellow-600 rounded hover:bg-yellow-100 transition">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    {{-- Delete Form --}}
                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 bg-red-50 text-red-600 rounded hover:bg-red-100 transition">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fas fa-box-open text-4xl mb-3 text-gray-300"></i>
                                    <p>No products found.</p>
                                    <a href="{{ route('admin.products.create') }}" class="mt-2 text-blue-600 hover:underline text-sm font-bold">Create New Product</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="p-4 border-t border-gray-100 dark:border-gray-700">
            {{ $products->links() }}
        </div>
    </div>
@endsection