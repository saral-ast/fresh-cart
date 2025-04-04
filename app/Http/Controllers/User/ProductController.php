<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Admin\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function filter(Request $request)
    {
        try {
            $query = Product::query();

            // Apply category filter only if a specific category is selected
            if ($request->has('category_id') && !empty($request->category_id)) {
                $query->where('category_id', $request->category_id);
            }

            // Apply price sorting
            if ($request->has('sort_price')) {
                $direction = $request->sort_price === 'asc' ? 'asc' : 'desc';
                $query->orderBy('price', $direction);
            } else {
                $query->latest('id');
            }

            $products = $query->with('category')->paginate(8);

            return response()->json([
                'success' => true,
                'products' => $products
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function index(Request $request)
    {
        try {
            $query = $request->input('search');
            
            $productsQuery = Product::latest("id");
            
            // Apply search filter if search parameter exists
            if ($query) {
                $productsQuery->where(function($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%");
                });
            }
            
            $products = $productsQuery->paginate(8);
            
            // Append search query to pagination links
            if ($query) {
                $products->appends(['search' => $query]);
            }
            
            return view('user.product.index', [
                'products' => $products,
                'searchQuery' => $query
            ]);
        } catch (\Exception $e) {
            return redirect()
                ->route('user.product.index')
                ->with('error', 'Failed to load products: ' . $e->getMessage());
        }
    }

    public function show($slug)
    {
        try {
            $product = Product::where('slug', $slug)
                ->with('category')
                ->firstOrFail();

            $relatedProducts = Product::where('category_id', $product->category_id)
                ->where('id', '!=', $product->id)
                ->latest()
                ->get();

            return view('user.product.show', [
                'product' => $product,
                'relatedProducts' => $relatedProducts
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()
                ->route('user.product.index')
                ->with('error', 'Product not found.');
        } catch (\Exception $e) {
            return redirect()
                ->route('user.product.index')
                ->with('error', 'Failed to load product details: ' . $e->getMessage());
        }
    }
    
    public function search(Request $request)
    {
        try {
            $query = $request->input('query');
            
            if (empty($query)) {
                return response()->json(['products' => []]);
            }
            
            $products = Product::where('name', 'like', "%{$query}%")
                ->limit(5)
                ->get(['id', 'name', 'slug', 'price', 'image']);
                
            return response()->json(['products' => $products]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to search products: ' . $e->getMessage()], 500);
        }
    }
}