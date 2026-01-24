<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
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
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string'
        ]);

        $data = $request->all();

        // Image Upload
        if ($request->hasFile('image')) {
            // storage/app/public/products ဖိုဒါထဲသိမ်းမည်
            $path = $request->file('image')->store('products', 'public');
            $data['image'] = $path;
        }

        // Checkbox value handling (on = 1, null = 0)
        $data['is_available'] = $request->has('is_available') ? 1 : 0;

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');
    }

    // ၄။ ပြင်ဆင်မည့် Form ပြခြင်း
    public function edit($id)
    {
        $product = Product::findOrFail($id);
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string'
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            // ပုံအသစ်တင်ရင် အဟောင်းဖျက်မယ်
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $data['is_available'] = $request->has('is_available') ? 1 : 0;

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
