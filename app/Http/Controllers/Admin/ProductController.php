<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Admin\Category;
use App\Models\Admin\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        try {
            $products = Product::latest()->with('category')->paginate(5);
            return view('admin.products.index', ['products' => $products]);
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.product.index')
                ->with('error', 'Failed to load products: ' . $e->getMessage());
        }
    }

    public function create()
    {
        try {
            $categories = Category::all();
            return view('admin.products.create', ['categories' => $categories]);
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.product.index')
                ->with('error', 'Failed to load create form: ' . $e->getMessage());
        }
    }

    public function store(ProductRequest $request)
    {
        try {
            $validatedData = $request->validated();
            
            $product = [
                'name' => $request->name,
                'slug' => $request->slug,
                'description' => $request->description,
                'price' => $request->price,
                'category_id' => $request->category_id,
                'featured' => $request->featured ? true : false,
            ];

            if ($request->hasFile('image')) {
                $product['image'] = $request->image->store('products', 'public');
            }

            Product::create($product);

            return redirect()
                ->route('admin.product.index')
                ->with('success', 'Product created successfully');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.product.index')
                ->with('error', 'Failed to create product: ' . $e->getMessage());
        }
    }

    public function edit(Product $product)
    {
        try {
            $categories = Category::all();
            return view('admin.products.edit', [
                'product' => $product,
                'categories' => $categories
            ]);
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.product.index')
                ->with('error', 'Failed to load edit form: ' . $e->getMessage());
        }
    }

    public function update(ProductRequest $request, Product $product)
    {
        try {
            $validatedData = $request->validated();
            $oldImagePath = $product->image;

            $updateData = [
                'name' => $request->name,
                'slug' => $request->slug,
                'description' => $request->description,
                'price' => $request->price,
                'category_id' => $request->category_id,
                'featured' => $request->featured ? true : false,
            ];

            if ($request->hasFile('image')) {
                $updateData['image'] = $request->image->store('products', 'public');
            } else {
                $updateData['image'] = $oldImagePath;
            }

            $product->update($updateData);

            if ($oldImagePath && $request->hasFile('image') && $oldImagePath !== $updateData['image']) {
                Storage::disk('public')->delete($oldImagePath);
            }

            return redirect()
                ->route('admin.product.index')
                ->with('success', 'Product updated successfully');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.product.index')
                ->with('error', 'Failed to update product: ' . $e->getMessage());
        }
    }

    public function destroy(Request $request, Product $product)
    {
        try {
            $product->delete();
            
            return redirect()
                ->route('admin.product.index')
                ->with('success', 'Product moved to trash successfully');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.product.index')
                ->with('error', 'Failed to delete product: ' . $e->getMessage());
        }
    }
    
    public function trash()
    {
        try {
            $trashedProducts = Product::onlyTrashed()->with('category')->paginate(5);
            
            return view('admin.products.trash', ['products' => $trashedProducts]);
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.product.index')
                ->with('error', 'Failed to load trashed products: ' . $e->getMessage());
        }
    }
    
    public function restore($id)
    {
        try {
            $product = Product::onlyTrashed()->findOrFail($id);
            $product->restore();
            
            return redirect()
                ->route('admin.product.trash')
                ->with('success', 'Product restored successfully');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.product.trash')
                ->with('error', 'Failed to restore product: ' . $e->getMessage());
        }
    }
    
    public function forceDelete($id)
    {
        try {
            $product = Product::onlyTrashed()->findOrFail($id);
            
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            
            $product->forceDelete();
            
            return redirect()
                ->route('admin.product.trash')
                ->with('success', 'Product permanently deleted successfully');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.product.trash')
                ->with('error', 'Failed to permanently delete product: ' . $e->getMessage());
        }
    }
}