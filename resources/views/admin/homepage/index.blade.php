@extends('layouts.admin')

@section('title', 'Homepage')

@section('content')
    <div class="space-y-6">
        @if (session('success'))
            <div class="rounded-2xl border border-green-200 bg-green-50 px-5 py-4 text-sm font-semibold text-green-700 dark:border-green-800 dark:bg-green-900/30 dark:text-green-300">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.homepage.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-700">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Just For You Section</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Change the title, subtitle, and choose which products appear on the homepage.</p>
                </div>

                <div class="grid gap-4 p-6 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-200">Section Title</label>
                        <input type="text" name="just_for_you_title" value="{{ old('just_for_you_title', $settings->just_for_you_title) }}" required
                            class="w-full rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm dark:border-gray-600 dark:bg-gray-700">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-200">Section Subtitle</label>
                        <input type="text" name="just_for_you_subtitle" value="{{ old('just_for_you_subtitle', $settings->just_for_you_subtitle) }}"
                            class="w-full rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm dark:border-gray-600 dark:bg-gray-700">
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-700">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Featured Products</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Tick the products you want to show in Just For You. Lower sort order appears first.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-900/40">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Show</th>
                                <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Sort</th>
                                <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Product</th>
                                <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Category</th>
                                <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Price</th>
                                <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Stock</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($products as $product)
                                <tr class="align-top">
                                    <td class="px-6 py-4">
                                        <input type="checkbox" name="featured_products[]" value="{{ $product->id }}"
                                            {{ old('featured_products') ? in_array($product->id, old('featured_products', [])) : ($product->is_featured_home ? 'checked' : '') }}>
                                    </td>
                                    <td class="px-6 py-4">
                                        <input type="number" min="0" name="featured_sort_order[{{ $product->id }}]"
                                            value="{{ old('featured_sort_order.' . $product->id, $product->featured_sort_order) }}"
                                            class="w-24 rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-700">
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                                class="h-14 w-14 rounded-xl object-cover">
                                            <div>
                                                <p class="font-semibold text-gray-900 dark:text-white">{{ $product->name }}</p>
                                                <p class="text-xs text-gray-500">{{ $product->code_number }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">{{ $product->category->name ?? '-' }}</td>
                                    <td class="px-6 py-4 text-sm font-semibold text-gray-900 dark:text-white">{{ number_format($product->price) }} MMK</td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">{{ $product->stock }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="border-t border-gray-200 px-6 py-5 dark:border-gray-700">
                    <button type="submit"
                        class="rounded-xl bg-blue-600 px-5 py-3 font-semibold text-white transition hover:bg-blue-700">
                        Save Homepage Settings
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
