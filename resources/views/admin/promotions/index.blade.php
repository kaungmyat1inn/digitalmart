@extends('layouts.admin')

@section('title', 'Promotion Slides')

@section('content')
    <div class="space-y-6">
        <div class="grid grid-cols-1 xl:grid-cols-[420px,minmax(0,1fr)] gap-6">
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Create Promotion Slide</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Add a new photo slide for the home page header carousel.</p>
                </div>

                <form action="{{ route('admin.promotions.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Title</label>
                        <input type="text" name="title" value="{{ old('title') }}" required
                            class="w-full rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 px-4 py-3 text-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Subtitle</label>
                        <input type="text" name="subtitle" value="{{ old('subtitle') }}"
                            class="w-full rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 px-4 py-3 text-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Description</label>
                        <textarea name="description" rows="4"
                            class="w-full rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 px-4 py-3 text-sm">{{ old('description') }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">CTA Label</label>
                            <input type="text" name="cta_label" value="{{ old('cta_label', 'Shop Now') }}"
                                class="w-full rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 px-4 py-3 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">CTA Link</label>
                            <input type="text" name="cta_link" value="{{ old('cta_link', '#products-section') }}"
                                class="w-full rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 px-4 py-3 text-sm">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Sort Order</label>
                            <input type="number" min="0" name="sort_order" value="{{ old('sort_order', $slides->count()) }}"
                                class="w-full rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 px-4 py-3 text-sm">
                        </div>
                        <label class="flex items-center gap-3 rounded-xl border border-gray-200 dark:border-gray-600 px-4 py-3 mt-7">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', '1') ? 'checked' : '' }}>
                            <span class="text-sm font-semibold text-gray-700 dark:text-gray-200">Show on homepage</span>
                        </label>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Promotion Image</label>
                        <input type="file" name="image" accept="image/*" required
                            class="w-full rounded-xl border border-dashed border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 px-4 py-3 text-sm">
                    </div>

                    <button type="submit"
                        class="w-full rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold px-5 py-3 shadow-lg shadow-blue-500/20 transition">
                        Add Slide
                    </button>
                </form>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between gap-4">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Carousel Slides</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Update the headline, action button, visibility, and order for each slide.</p>
                    </div>
                    <span class="px-3 py-1 rounded-full bg-blue-50 text-blue-600 text-sm font-bold">{{ $slides->count() }} slides</span>
                </div>

                <div class="p-6 space-y-5">
                    @forelse ($slides as $slide)
                        <div class="rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                            <div class="grid grid-cols-1 lg:grid-cols-[240px,minmax(0,1fr)]">
                                <div class="bg-gray-100 dark:bg-gray-900 min-h-[220px]">
                                    <img src="{{ $slide->image_url }}" alt="{{ $slide->title }}" class="w-full h-full object-cover">
                                </div>

                                <div class="p-5">
                                    <form action="{{ route('admin.promotions.update', $slide) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                                        @csrf
                                        @method('PUT')

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Title</label>
                                                <input type="text" name="title" value="{{ old('title', $slide->title) }}" required
                                                    class="w-full rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 px-4 py-3 text-sm">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Subtitle</label>
                                                <input type="text" name="subtitle" value="{{ old('subtitle', $slide->subtitle) }}"
                                                    class="w-full rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 px-4 py-3 text-sm">
                                            </div>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Description</label>
                                            <textarea name="description" rows="3"
                                                class="w-full rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 px-4 py-3 text-sm">{{ old('description', $slide->description) }}</textarea>
                                        </div>

                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">CTA Label</label>
                                                <input type="text" name="cta_label" value="{{ old('cta_label', $slide->cta_label) }}"
                                                    class="w-full rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 px-4 py-3 text-sm">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">CTA Link</label>
                                                <input type="text" name="cta_link" value="{{ old('cta_link', $slide->cta_link) }}"
                                                    class="w-full rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 px-4 py-3 text-sm">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Sort Order</label>
                                                <input type="number" min="0" name="sort_order" value="{{ old('sort_order', $slide->sort_order) }}" required
                                                    class="w-full rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 px-4 py-3 text-sm">
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-1 md:grid-cols-[1fr,auto,auto] gap-4 items-end">
                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Replace Image</label>
                                                <input type="file" name="image" accept="image/*"
                                                    class="w-full rounded-xl border border-dashed border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 px-4 py-3 text-sm">
                                            </div>

                                            <label class="flex items-center gap-3 rounded-xl border border-gray-200 dark:border-gray-600 px-4 py-3">
                                                <input type="checkbox" name="is_active" value="1" {{ $slide->is_active ? 'checked' : '' }}>
                                                <span class="text-sm font-semibold text-gray-700 dark:text-gray-200">Active</span>
                                            </label>

                                            <div class="flex gap-3">
                                                <button type="submit"
                                                    class="rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-3 transition">
                                                    Save
                                                </button>
                                            </div>
                                        </div>
                                    </form>

                                    <div class="mt-4 flex justify-end">
                                                <form action="{{ route('admin.promotions.destroy', $slide) }}" method="POST" onsubmit="return confirm('Delete this promotion slide?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="rounded-xl bg-red-50 hover:bg-red-100 text-red-600 font-semibold px-5 py-3 transition">
                                                        Delete
                                                    </button>
                                                </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="rounded-2xl border border-dashed border-gray-300 dark:border-gray-600 p-12 text-center">
                            <div class="w-16 h-16 mx-auto rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-2xl mb-4">
                                <i class="fas fa-images"></i>
                            </div>
                            <h4 class="text-lg font-bold text-gray-900 dark:text-white">No promotion slides yet</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Create your first hero slide to power the homepage carousel.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
