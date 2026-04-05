<?php

namespace App\Http\Controllers;

use App\Models\PromotionSlide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PromotionSlideController extends Controller
{
    public function index()
    {
        $slides = PromotionSlide::orderBy('sort_order')->orderByDesc('created_at')->get();

        return view('admin.promotions.index', compact('slides'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:4096',
            'cta_label' => 'nullable|string|max:80',
            'cta_link' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $data['image'] = $request->file('image')->store('promotions', 'public');
        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = $data['sort_order'] ?? ((PromotionSlide::max('sort_order') ?? -1) + 1);

        PromotionSlide::create($data);

        return redirect()->route('admin.promotions.index')->with('success', 'Promotion slide created successfully.');
    }

    public function update(Request $request, PromotionSlide $promotion)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'cta_label' => 'nullable|string|max:80',
            'cta_link' => 'nullable|string|max:255',
            'sort_order' => 'required|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($promotion->image && Storage::disk('public')->exists($promotion->image)) {
                Storage::disk('public')->delete($promotion->image);
            }

            $data['image'] = $request->file('image')->store('promotions', 'public');
        }

        $data['is_active'] = $request->boolean('is_active');

        $promotion->update($data);

        return redirect()->route('admin.promotions.index')->with('success', 'Promotion slide updated successfully.');
    }

    public function destroy(PromotionSlide $promotion)
    {
        if ($promotion->image && Storage::disk('public')->exists($promotion->image)) {
            Storage::disk('public')->delete($promotion->image);
        }

        $promotion->delete();

        return redirect()->route('admin.promotions.index')->with('success', 'Promotion slide deleted successfully.');
    }
}
