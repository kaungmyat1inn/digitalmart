<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // ၁။ Product List ပြခြင်း
    public function index()
    {
        $categories = Category::withCount('products')->get();
        $query = Product::with('category')->latest();

        if ($search = request('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('code_number', 'like', "%$search%");
            });
        }

        if ($categoryId = request('category')) {
            $query->where('category_id', $categoryId);
        }

        $products = $query->paginate(10)->appends(request()->all());

        return view('admin.products.index', compact('products', 'categories'));
    }

    // ၂။ အသစ်ထည့်မည့် Form ပြခြင်း
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    // ၃။ Database ထဲသို့ သိမ်းခြင်း
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'code_number' => 'required|unique:products,code_number',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'group_id' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'gallery_images' => 'nullable|array',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'description' => 'nullable|string',
            'supplier' => 'nullable|string'
        ]);

        $data = $request->except(['gallery_images']);

        // Ensure stock is set and valid
        $data['stock'] = isset($data['stock']) && is_numeric($data['stock']) && $data['stock'] > 0 ? (int)$data['stock'] : 1;

        // Image Upload
        if ($request->hasFile('image')) {
            // storage/app/public/products ဖိုဒါထဲသိမ်းမည်
            $path = $request->file('image')->store('products', 'public');
            $data['image'] = $path;
        }

        $product = Product::create($data);

        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $index => $image) {
                if (!$image) {
                    continue;
                }

                $path = $image->store('products', 'public');

                $product->images()->create([
                    'image_path' => $path,
                    'sort_order' => $index,
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');
    }

    // ၄။ ပြင်ဆင်မည့် Form ပြခြင်း
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $product->load('images');
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    // ၅။ Database တွင် ပြင်ဆင်ခြင်း
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'code_number' => 'required|unique:products,code_number,' . $id,
            'price' => 'required|numeric',
            'category_id' => 'nullable|exists:categories,id',
            'group_id' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'gallery_images' => 'nullable|array',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'remove_gallery_images' => 'nullable|array',
            'remove_gallery_images.*' => 'nullable|integer',
            'description' => 'nullable|string',
            'supplier' => 'nullable|string'
        ]);

        $data = $request->except(['gallery_images', 'remove_gallery_images']);

        if ($request->hasFile('image')) {
            // ပုံအသစ်တင်ရင် အဟောင်းဖျက်မယ်
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        if ($request->filled('remove_gallery_images')) {
            $imagesToRemove = $product->images()->whereIn('id', $request->remove_gallery_images)->get();

            foreach ($imagesToRemove as $galleryImage) {
                if ($galleryImage->image_path && Storage::disk('public')->exists($galleryImage->image_path)) {
                    Storage::disk('public')->delete($galleryImage->image_path);
                }
            }

            $product->images()->whereIn('id', $request->remove_gallery_images)->delete();
        }

        if ($request->hasFile('gallery_images')) {
            $nextSortOrder = ((int) $product->images()->max('sort_order')) + 1;

            foreach ($request->file('gallery_images') as $image) {
                if (!$image) {
                    continue;
                }

                $path = $image->store('products', 'public');

                $product->images()->create([
                    'image_path' => $path,
                    'sort_order' => $nextSortOrder++,
                ]);
            }
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
    }

    // ၆။ ဖျက်ခြင်း (Delete) - *Error တက်နေသည့် Function*
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // ပုံပါဖျက်မယ်
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        foreach ($product->images as $image) {
            if ($image->image_path && Storage::disk('public')->exists($image->image_path)) {
                Storage::disk('public')->delete($image->image_path);
            }
        }

        $product->delete();

        return back()->with('success', 'Product deleted successfully!');
    }
    // Auto Generate Code Number
    public function generateCode(Request $request)
    {
        $categoryId = $request->category_id;

        // Model မရှိရင် Error မတက်အောင် path အပြည့်စုံသုံးမယ်
        $category = \App\Models\Category::find($categoryId);

        if (!$category) {
            return response()->json(['code' => '']);
        }

        $cleanName = preg_replace('/[^A-Za-z0-9]/', '', $category->name);

        if (!empty($cleanName)) {
            $prefix = strtoupper(substr($cleanName, 0, 3));
        } else {
            $prefix = "CAT" . $category->id;
        }

        $latestProduct = \App\Models\Product::withTrashed()->where('code_number', 'like', "$prefix-%")
            ->orderByRaw('LENGTH(code_number) DESC')
            ->orderBy('code_number', 'desc')
            ->first();

        if ($latestProduct) {
            $parts = explode('-', $latestProduct->code_number);
            $number = intval(end($parts)) + 1;
        } else {
            $number = 1;
        }

        $newCode = $prefix . '-' . str_pad($number, 4, '0', STR_PAD_LEFT);

        return response()->json(['code' => $newCode]);
    }
}
