@extends('layouts.admin')

@section('title', 'Manage Categories')

@section('content')
    <div class="max-w-6xl mx-auto">
        {{-- Header --}}
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-3xl font-bold text-gray-800 dark:text-white">Categories</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Manage product categories</p>
            </div>
            <button onclick="openAddModal()"
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow transition flex items-center gap-2">
                <i class="fas fa-plus"></i> Add Category
            </button>
        </div>

        {{-- Success/Error Messages --}}
        @if (session('success'))
            <div
                class="mb-6 p-4 bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-300 rounded-lg flex items-center gap-3">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
                <button type="button" onclick="this.parentElement.remove()" class="ml-auto text-xl">&times;</button>
            </div>
        @endif

        @if (session('error'))
            <div
                class="mb-6 p-4 bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-300 rounded-lg flex items-center gap-3">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ session('error') }}</span>
                <button type="button" onclick="this.parentElement.remove()" class="ml-auto text-xl">&times;</button>
            </div>
        @endif

        {{-- Categories Table --}}
        <div
            class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
            @if ($categories->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                            <tr>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    Category Name
                                </th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    Products
                                </th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    Created
                                </th>
                                <th class="px-6 py-4 text-right text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($categories as $category)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="h-8 w-8 bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300 rounded flex items-center justify-center">
                                                <i class="fas fa-tag text-sm"></i>
                                            </div>
                                            <span class="font-medium text-gray-800 dark:text-white">{{ $category->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 dark:bg-blue-900/50 text-blue-700 dark:text-blue-300">
                                            {{ $category->products_count }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                        {{ $category->created_at->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            @if ($category->products_count == 0)
                                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST"
                                                    class="inline"
                                                    onsubmit="return confirm('Are you sure you want to delete this category?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="p-2 bg-red-50 text-red-600 rounded hover:bg-red-100 transition">
                                                        <i class="fas fa-trash text-sm"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <button disabled title="Cannot delete category with products"
                                                    class="p-2 bg-gray-100 dark:bg-gray-700 text-gray-400 rounded cursor-not-allowed">
                                                    <i class="fas fa-trash text-sm"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-12 text-center">
                    <div
                        class="h-16 w-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-inbox text-2xl text-gray-400 dark:text-gray-500"></i>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">No categories yet</p>
                    <button onclick="openAddModal()"
                        class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition">
                        <i class="fas fa-plus"></i> Create First Category
                    </button>
                </div>
            @endif
        </div>
    </div>

    {{-- Add Category Modal --}}
    <div id="addCategoryModal"
        class="fixed inset-0 z-50 hidden bg-gray-900 bg-opacity-50 backdrop-blur-sm flex items-center justify-center transition-opacity">
        <div
            class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl p-6 w-full max-w-md transform scale-100 transition-transform">
            <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Add New Category</h3>

            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Category Name
                    </label>
                    <input type="text" id="name" name="name" required autocomplete="off"
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                        placeholder="e.g., Electronics, Clothing">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeAddModal()"
                        class="px-4 py-2 text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 shadow-lg transition flex items-center gap-2">
                        <i class="fas fa-check"></i> Create Category
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const addCategoryModal = document.getElementById('addCategoryModal');

        function openAddModal() {
            addCategoryModal.classList.remove('hidden');
        }

        function closeAddModal() {
            addCategoryModal.classList.add('hidden');
        }

        // Close modal when clicking outside
        addCategoryModal.addEventListener('click', function (e) {
            if (e.target === addCategoryModal) {
                closeAddModal();
            }
        });
    </script>
@endsection