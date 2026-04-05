<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * List products with pagination, search, and category filter.
     */
    public function index(Request $request)
    {
        $query = Product::with(['category', 'variants', 'images'])
            ->withCount('orderItems')
            ->when($request->search, function ($q, $search) {
                return $q->where(function ($subQ) use ($search) {
                    $subQ->where('name', 'like', "%{$search}%")
                        ->orWhere('code_number', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->when($request->category, function ($q, $category) {
                return $q->whereHas('category', function ($subQ) use ($category) {
                    $subQ->where('slug', $category);
                });
            })
            ->when($request->sort, function ($q, $sort) {
                switch ($sort) {
                    case 'newest':
                        return $q->latest();
                    case 'price_asc':
                        return $q->orderBy('price', 'asc');
                    case 'price_desc':
                        return $q->orderBy('price', 'desc');
                    case 'popular':
                        return $q->orderBy('order_items_count', 'desc');
                    default:
                        return $q->orderByRaw('CASE WHEN stock > 0 THEN 1 ELSE 0 END DESC');
                }
            });

        $products = $query->paginate($request->per_page ?? 16);

        return response()->json([
            'success' => true,
            'data' => $products,
        ]);
    }

    /**
     * Get single product details.
     */
    public function show($id)
    {
        $product = Product::with(['category', 'variants', 'images'])
            ->withCount('orderItems')
            ->find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $product,
        ]);
    }

    /**
     * List all categories.
     */
    public function categories()
    {
        $categories = Category::withCount('products')
            ->orderBy('name')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $categories,
        ]);
    }

    /**
     * Get category with products.
     */
    public function categoryShow($id)
    {
        $category = Category::with(['products' => function ($query) {
                $query->withCount('orderItems')
                    ->orderByRaw('CASE WHEN stock > 0 THEN 1 ELSE 0 END DESC')
                    ->orderBy('order_items_count', 'desc');
            }])
            ->withCount('products')
            ->find($id);

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $category,
        ]);
    }
}
