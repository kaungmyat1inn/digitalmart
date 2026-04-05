<?php

namespace App\Http\Controllers;

use App\Models\HomepageSetting;
use App\Models\Product;
use Illuminate\Http\Request;

class HomepageSettingController extends Controller
{
    public function index()
    {
        $settings = HomepageSetting::firstOrCreate(
            ['id' => 1],
            [
                'just_for_you_title' => 'Just For You',
                'just_for_you_subtitle' => 'Simple product list for easy browsing.',
            ]
        );

        $products = Product::with('category')
            ->orderByDesc('is_featured_home')
            ->orderBy('featured_sort_order')
            ->latest()
            ->get();

        return view('admin.homepage.index', compact('settings', 'products'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'just_for_you_title' => 'required|string|max:255',
            'just_for_you_subtitle' => 'nullable|string|max:255',
            'featured_products' => 'nullable|array',
            'featured_products.*' => 'nullable|integer|exists:products,id',
            'featured_sort_order' => 'nullable|array',
            'featured_sort_order.*' => 'nullable|integer|min:0',
        ]);

        $settings = HomepageSetting::firstOrCreate(['id' => 1]);
        $settings->update([
            'just_for_you_title' => $data['just_for_you_title'],
            'just_for_you_subtitle' => $data['just_for_you_subtitle'] ?? 'Simple product list for easy browsing.',
        ]);

        Product::query()->update([
            'is_featured_home' => false,
            'featured_sort_order' => 0,
        ]);

        $featuredIds = collect($data['featured_products'] ?? [])
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->values();

        foreach ($featuredIds as $position => $productId) {
            $sortOrder = (int) ($data['featured_sort_order'][$productId] ?? $position);

            Product::whereKey($productId)->update([
                'is_featured_home' => true,
                'featured_sort_order' => $sortOrder,
            ]);
        }

        return redirect()->route('admin.homepage.index')->with('success', 'Homepage settings updated successfully.');
    }
}
