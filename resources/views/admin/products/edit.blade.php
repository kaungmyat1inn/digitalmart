@extends('layouts.admin')

@section('title', 'Edit Product')

@section('content')
    <div class="max-w-5xl mx-auto">

        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-3xl font-bold text-gray-800 dark:text-white">Edit Product</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Update product information and images</p>
            </div>
            <a href="{{ route('admin.products.index', absolute: false) }}"
                class="px-4 py-2 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-lg shadow-sm border border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 transition flex items-center gap-2">
                <i class="fas fa-arrow-left text-sm"></i> Back to List
            </a>
        </div>

        <form id="product-form" action="{{ route('admin.products.update', ['id' => $product->id], absolute: false) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <div class="lg:col-span-2 space-y-6">
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                        <h3
                            class="font-bold text-gray-800 dark:text-white mb-4 text-lg border-b border-gray-100 dark:border-gray-700 pb-3">
                            Basic Information</h3>

                        <div class="space-y-5">
                            {{-- Product Name --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Product
                                    Name</label>
                                <input type="text" name="name" value="{{ old('name', $product->name) }}" required
                                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm placeholder-gray-400">
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                {{-- Category --}}
                                <div>
                                    <label
                                        class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Category</label>
                                    <div class="relative">
                                        <select name="category_id" id="category-select"
                                            onchange="handleCategoryChange(this)"
                                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none transition shadow-sm">
                                            <option value="">Select Category...</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                            <option disabled>-------------------</option>
                                            <option value="new_category"
                                                class="font-bold text-blue-600 bg-blue-50 dark:bg-gray-600">+ Create New
                                                Category</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- Code Number --}}
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Code
                                        Number</label>
                                    <input type="text" id="code_number" name="code_number"
                                        value="{{ old('code_number', $product->code_number) }}" required
                                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm">
                                </div>
                                {{-- Group ID --}}
                                <div>
                                    <label for="group_id"
                                        class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Product Group
                                    </label>
                                    <input type="text" id="group_id" name="group_id"
                                        value="{{ old('group_id', $product->group_id) }}"
                                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm"
                                        placeholder="Enter group ID (optional)">
                                </div>
                                {{-- Supplier --}}
                                <div>
                                    <label for="supplier"
                                        class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Supplier
                                    </label>
                                    <input type="text" id="supplier" name="supplier"
                                        value="{{ old('supplier', $product->supplier) }}"
                                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm"
                                        placeholder="Enter supplier name (optional)">
                                </div>
                            </div>

                            {{-- Price & Status --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Price
                                        (Ks)</label>
                                    <input type="number" name="price" value="{{ old('price', $product->price) }}" required
                                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm">
                                </div>
                                <div>
                                    <label for="stock"
                                        class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Stock</label>
                                    <input type="number" id="stock" name="stock" value="{{ old('stock', $product->stock) }}"
                                        min="0" required autocomplete="off"
                                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm"
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
                                    placeholder="Enter product description...">{{ old('description', $product->description) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-1">
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 sticky top-6">
                        <h3
                            class="font-bold text-gray-800 dark:text-white mb-4 text-lg border-b border-gray-100 dark:border-gray-700 pb-3">
                            Product Image</h3>

                        <div class="space-y-4">
                            <div class="relative w-full aspect-square bg-gray-100 dark:bg-gray-900 rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-600 flex flex-col items-center justify-center overflow-hidden hover:border-blue-500 transition group cursor-pointer"
                                onclick="document.getElementById('image-input').click()">

                                {{-- Logic for Image URL --}}
                                @php
                                    $imageUrl = 'https://placehold.co/600x600?text=Upload+Image';
                                    if ($product->image) {
                                        $imageUrl = Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image);
                                    }
                                @endphp

                                {{-- Image Tag with Blur Transition --}}
                                <img id="image-preview" src="{{ $imageUrl }}"
                                    class="absolute inset-0 w-full h-full object-cover transition-all duration-700 ease-out">

                                {{-- Progress Overlay (Initially Hidden) --}}
                                <div id="upload-overlay"
                                    class="absolute inset-0 bg-black/60 z-10 hidden flex-col items-center justify-center backdrop-blur-sm">
                                    <div class="w-20 h-20 relative flex items-center justify-center">
                                        <svg class="animate-spin h-full w-full text-blue-500"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>
                                        </svg>
                                        <span id="upload-percent" class="absolute text-white font-bold text-sm">0%</span>
                                    </div>
                                    <p class="text-white text-sm mt-2 font-medium">Uploading...</p>
                                </div>

                                {{-- Change Icon --}}
                                <div id="change-icon"
                                    class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition flex items-center justify-center">
                                    <div
                                        class="bg-white/90 text-gray-800 px-4 py-2 rounded-lg font-bold shadow-lg transform translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition">
                                        <i class="fas fa-camera mr-2"></i> Change
                                    </div>
                                </div>
                            </div>

                            <input type="file" name="image" id="image-input" accept="image/*" class="hidden">
                            <p class="text-xs text-center text-gray-500 dark:text-gray-400">Click to upload (JPEG, PNG)</p>

                            <div class="border-t border-gray-100 pt-4 dark:border-gray-700">
                                <div class="mb-3 flex items-center justify-between">
                                    <div>
                                        <h4 class="text-sm font-bold text-gray-800 dark:text-white">Additional Images</h4>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Manage extra photos for the detail page carousel.</p>
                                    </div>
                                    <button type="button" id="add-gallery-image"
                                        class="rounded-lg bg-blue-50 px-3 py-2 text-xs font-bold text-blue-600 transition hover:bg-blue-100">
                                        + Add
                                    </button>
                                </div>

                                @if ($product->images->isNotEmpty())
                                    <div class="mb-4 space-y-3">
                                        @foreach ($product->images as $galleryImage)
                                            <label class="flex items-center gap-3 rounded-xl border border-gray-200 p-3 dark:border-gray-700">
                                                <img src="{{ $galleryImage->image_url }}" alt="Gallery image"
                                                    class="h-14 w-14 rounded-lg object-cover">
                                                <div class="flex-1">
                                                    <p class="text-xs font-semibold text-gray-700 dark:text-gray-200">Existing image</p>
                                                    <p class="text-[11px] text-gray-500 dark:text-gray-400">Check to remove this photo</p>
                                                </div>
                                                <input type="checkbox" name="remove_gallery_images[]" value="{{ $galleryImage->id }}">
                                            </label>
                                        @endforeach
                                    </div>
                                @endif

                                <div id="gallery-inputs" class="space-y-3"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="mt-8 flex justify-end gap-3 pt-6 border-t border-gray-100 dark:border-gray-700">
                <a href="{{ route('admin.products.index', absolute: false) }}"
                    class="px-6 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-medium hover:bg-gray-50 dark:hover:bg-gray-700 transition">Cancel</a>

                {{-- Button type="button" to prevent default submit, we handle in JS --}}
                <button type="submit" id="submit-btn"
                    class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow-lg flex items-center gap-2">
                    <i class="fas fa-save"></i> Update Product
                </button>
            </div>
        </form>
    </div>

    {{-- Script for Image Preview --}}
    <template id="gallery-input-template">
        <div class="gallery-input-item rounded-xl border border-gray-200 p-3 dark:border-gray-700">
            <div class="flex items-center justify-between gap-3">
                <input type="file" name="gallery_images[]" accept="image/*"
                    class="block w-full text-xs text-gray-600 file:mr-3 file:rounded-lg file:border-0 file:bg-gray-100 file:px-3 file:py-2 file:text-xs file:font-semibold hover:file:bg-gray-200 dark:text-gray-300 dark:file:bg-gray-700 dark:hover:file:bg-gray-600">
                <button type="button" class="remove-gallery-input rounded-lg px-2 py-2 text-xs font-bold text-red-500 hover:bg-red-50">
                    Remove
                </button>
            </div>
        </div>
    </template>

    <script>
        // 1. Image Preview Logic
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

        // 2. Standard Form Submit
        document.getElementById('product-form').addEventListener('submit', function () {
            const overlay = document.getElementById('upload-overlay');
            const imagePreview = document.getElementById('image-preview');
            const submitBtn = document.getElementById('submit-btn');

            overlay.classList.remove('hidden');
            overlay.classList.add('flex');
            imagePreview.classList.add('blur-sm');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Processing...';
        });

        // Handle Category Change for Code Generation
        const categorySelect = document.getElementById('category-select');
        const codeInput = document.getElementById('code_number');
        const galleryInputs = document.getElementById('gallery-inputs');
        const galleryTemplate = document.getElementById('gallery-input-template').content;
        const addGalleryButton = document.getElementById('add-gallery-image');
        let previousValue = categorySelect.value;

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
                const url = `{{ route('admin.products.generateCode', absolute: false) }}?category_id=${selectedValue}`;
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

        const appendGalleryInput = () => {
            galleryInputs.appendChild(galleryTemplate.cloneNode(true));
        };

        addGalleryButton.addEventListener('click', appendGalleryInput);

        galleryInputs.addEventListener('click', function(event) {
            if (event.target.classList.contains('remove-gallery-input')) {
                event.target.closest('.gallery-input-item')?.remove();
            }
        });
    </script>

    {{-- Include Category Modal Code Here as well --}}
    {{-- (Insert the Category Modal Code from previous steps here) --}}

@endsection
