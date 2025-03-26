<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Admin\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        try {
            $products = Product::latest("id")->paginate(8);
            return view('user.product.index', ['products' => $products]);
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
}