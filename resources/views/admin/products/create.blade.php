@extends('layouts.admin')

@section('title', 'Add New Product')

@section('content')
    <div class="max-w-5xl mx-auto">

        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-3xl font-bold text-gray-800 dark:text-white">Add New Product</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Create a new product for your store</p>
            </div>
            <a href="{{ route('admin.products.index') }}"
                class="px-4 py-2 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-lg shadow-sm border border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 transition flex items-center gap-2">
                <i class="fas fa-arrow-left text-sm"></i> Back to List
            </a>
        </div>

        <form id="product-form" action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <h4 class="font-bold text-red-600 mb-2">Please fix the following errors:</h4>
                    <ul class="list-disc list-inside text-sm text-red-600">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <div class="lg:col-span-2 space-y-6">
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                        <h3
                            class="font-bold text-gray-800 dark:text-white mb-4 text-lg border-b border-gray-100 dark:border-gray-700 pb-3">
                            Basic Information
                        </h3>

                        <div class="space-y-5">
                            {{-- Product Name --}}
                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Product Name
                                </label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm placeholder-gray-400 @error('name') border-red-500 @enderror"
                                    placeholder="Enter product name">
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                {{-- Category --}}
                                <div>
                                    <label for="category-select"
                                        class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Category
                                    </label>
                                    <div class="relative">
                                        <select name="category_id" id="category-select"
                                            onchange="handleCategoryChange(this)"
                                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none transition shadow-sm @error('category_id') border-red-500 @enderror">

                                            <option value="">Select Category...</option>

                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach

                                            <option disabled>-------------------</option>
                                            <option value="new_category"
                                                class="font-bold text-blue-600 bg-blue-50 dark:bg-gray-600">
                                                + Create New Category (အသစ်ထည့်မည်)
                                            </option>

                                        </select>
                                        <div
                                            class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-gray-500">
                                            <i class="fas fa-chevron-down text-xs"></i>
                                        </div>
                                    </div>
                                </div>

                                {{-- Code Number --}}
                                <div>
                                    <label for="code_number"
                                        class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Code Number
                                    </label>
                                    <div class="relative">
                                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">
                                            <i class="fas fa-barcode"></i>
                                        </span>
                                        <input type="text" id="code_number" name="code_number"
                                            value="{{ old('code_number') }}" required autocomplete="off"
                                            class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm @error('code_number') border-red-500 @enderror">
                                    </div>
                                </div>
                                {{-- Group ID --}}
                                <div>
                                    <label for="group_id"
                                        class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Product Group
                                    </label>
                                    <input type="text" id="group_id" name="group_id" value="{{ old('group_id') }}"
                                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm"
                                        placeholder="Enter group ID (optional)">
                                </div>

                                {{-- Supplier --}}
                                <div>
                                    <label for="supplier"
                                        class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Supplier
                                    </label>
                                    <input type="text" id="supplier" name="supplier" value="{{ old('supplier') }}"
                                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm"
                                        placeholder="Enter supplier name (optional)">
                                </div>
                            </div>

                            {{-- Price & Status --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label for="price"
                                        class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Price
                                        (Ks)</label>
                                    <input type="number" id="price" name="price" value="{{ old('price') }}" required
                                        autocomplete="off"
                                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm @error('price') border-red-500 @enderror"
                                        placeholder="0">
                                </div>
                                <div>
                                    <label for="stock"
                                        class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Stock</label>
                                    <input type="number" id="stock" name="stock" value="{{ old('stock', 0) }}" min="0"
                                        required autocomplete="off"
                                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm @error('stock') border-red-500 @enderror"
                                        placeholder="0">
                                </div>
                                <div class="flex flex-col justify-end pb-2">
                                    <!-- is_available removed -->
                                </div>
                            </div>

                            {{-- Description --}}
                            <div>
                                <label for="description"
                                    class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Description
                                </label>
                                <textarea id="description" name="description" rows="4"
                                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm placeholder-gray-400"
                                    placeholder="Enter product description...">{{ old('description') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right Column: Image Upload --}}
                <div class="lg:col-span-1">
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 sticky top-6">
                        <h3
                            class="font-bold text-gray-800 dark:text-white mb-4 text-lg border-b border-gray-100 dark:border-gray-700 pb-3">
                            Product Image
                        </h3>

                        <div class="space-y-4">
                            <div class="relative w-full aspect-square bg-gray-100 dark:bg-gray-900 rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-600 flex flex-col items-center justify-center overflow-hidden hover:border-blue-500 transition group cursor-pointer"
                                onclick="document.getElementById('image-input').click()">

                                <img id="image-preview" src="https://placehold.co/600x600?text=Upload+Image"
                                    class="absolute inset-0 w-full h-full object-cover transition-all duration-700 ease-out">

                                <div
                                    class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition flex items-center justify-center">
                                    <div
                                        class="bg-white/90 text-gray-800 px-4 py-2 rounded-lg font-bold shadow-lg transform translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition">
                                        <i class="fas fa-camera mr-2"></i> Upload
                                    </div>
                                </div>
                            </div>

                            <input type="file" name="image" id="image-input" accept="image/*"
                                class="hidden @error('image') border-red-500 @enderror">

                            <p class="text-xs text-center text-gray-500 dark:text-gray-400">
                                Click the image to upload.<br>
                                Recommended: 600x600px (JPEG, PNG)
                            </p>
                        </div>
                    </div>
                </div>

            </div>

            <div class="mt-8 flex justify-end gap-3 pt-6 border-t border-gray-100 dark:border-gray-700">
                <a href="{{ route('admin.products.index') }}"
                    class="px-6 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-medium hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    Cancel
                </a>
                <button type="submit" id="submit-btn"
                    class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow-lg hover:shadow-blue-500/30 transition flex items-center gap-2">
                    <i class="fas fa-save"></i> Save Product
                </button>
            </div>

        </form>
    </div>

    {{-- Script for Immediate Image Preview --}}
    <script>
        document.getElementById('image-input').addEventListener('change', function (event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('image-preview').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    </script>

    {{-- Quick Add Category Modal --}}
    <div id="category-modal"
        class="fixed inset-0 z-50 hidden bg-gray-900 bg-opacity-50 backdrop-blur-sm flex items-center justify-center transition-opacity">
        <div
            class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl p-6 w-full max-w-md transform scale-100 transition-transform">
            <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Add New Category</h3>

            <div class="mb-4">
                <label for="new-category-name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Category Name
                </label>
                <input type="text" id="new-category-name" autocomplete="off"
                    class="w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-blue-500 focus:border-blue-500"
                    placeholder="e.g. Smart Watch">
                <p id="cat-error" class="text-red-500 text-xs mt-1 hidden"></p>
            </div>

            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeCategoryModal()"
                    class="px-4 py-2 text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300">Cancel</button>
                <button type="button" onclick="saveNewCategory()"
                    class="px-4 py-2 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 shadow-lg flex items-center gap-2">
                    <span id="cat-loading" class="hidden"><i class="fas fa-spinner fa-spin"></i></span> Save Category
                </button>
            </div>
        </div>
    </div>

    <script>
        const categorySelect = document.getElementById('category-select');
        const categoryModal = document.getElementById('category-modal');
        const categoryInput = document.getElementById('new-category-name');
        const codeInput = document.getElementById('code_number');
        let previousValue = "";

        function handleCategoryChange(select) {
            const selectedValue = select.value;
            if (selectedValue === 'new_category') {
                categoryModal.classList.remove('hidden');
                categoryInput.focus();
                return;
            }
            previousValue = selectedValue;
            if (selectedValue) {
                codeInput.value = "Generating...";
                codeInput.classList.add('bg-gray-100', 'animate-pulse');
                const url = `{{ route('admin.products.generateCode') }}?category_id=${selectedValue}`;
                console.log('Fetching from:', url);
                fetch(url)
                    .then(response => {
                        console.log('Response status:', response.status);
                        if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                        return response.json();
                    })
                    .then(data => {
                        console.log('Response data:', data);
                        if (data && data.code) {
                            codeInput.value = data.code;
                        } else {
                            console.warn('No code in response:', data);
                            codeInput.value = "";
                        }
                        codeInput.classList.remove('bg-gray-100', 'animate-pulse');
                    })
                    .catch(error => {
                        console.error('Error generating code:', error);
                        codeInput.value = "";
                        codeInput.classList.remove('bg-gray-100', 'animate-pulse');
                    });
            } else {
                codeInput.value = "";
            }
        }

        function closeCategoryModal() {
            categoryModal.classList.add('hidden');
            categorySelect.value = previousValue;
            categoryInput.value = "";
            document.getElementById('cat-error').classList.add('hidden');
        }

        function saveNewCategory() {
            const name = categoryInput.value.trim();
            const loading = document.getElementById('cat-loading');
            const errorMsg = document.getElementById('cat-error');
            if (!name) {
                errorMsg.textContent = "Category name is required";
                errorMsg.classList.remove('hidden');
                return;
            }
            loading.classList.remove('hidden');
            const url = "{{ route('admin.categories.storeAjax') }}";
            console.log('Sending category to:', url);
            fetch(url, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ name: name })
            })
                .then(response => {
                    console.log('Response status:', response.status);
                    return response.json();
                })
                .then(data => {
                    console.log('Response data:', data);
                    loading.classList.add('hidden');
                    if (data.success) {
                        const newOption = new Option(data.category.name, data.category.id, true, true);
                        const separatorIndex = categorySelect.options.length - 2;
                        if (separatorIndex >= 0) {
                            categorySelect.add(newOption, categorySelect.options[separatorIndex]);
                        } else {
                            categorySelect.add(newOption);
                        }
                        previousValue = data.category.id;
                        closeCategoryModal();
                        handleCategoryChange(categorySelect);
                    } else {
                        errorMsg.textContent = data.message || "Something went wrong";
                        errorMsg.classList.remove('hidden');
                    }
                })
                .catch(error => {
                    loading.classList.add('hidden');
                    console.error('Error:', error);
                    errorMsg.textContent = 'Network error: ' + error.message;
                    errorMsg.classList.remove('hidden');
                });
        }
    </script>
@endsection