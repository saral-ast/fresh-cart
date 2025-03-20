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
    /**
     * Show the form for creating the resource.
     */
    public function index(){
        
        $products = Product::latest()->with('category')->paginate(5);
        return view('admin.products.index',['products'=> $products]);
    }
    public function create() 
    {
        $categories = Category::all();
        // dd($categories);

        return view('admin.products.create',['categories'=> $categories]);
    }

    /**
     * Store the newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
       $request->validated();
       $product = [
            'name' => $request->name,
            'slug' => $request->slug,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'featured' => $request->featured ? true : false,
       ];
       $product['image'] = $request->image->store('products','public');
       Product::create($product);
       return redirect()->route('admin.product.index')->with('success', 'Product created successfully');
    }

    /**
     * Display the resource.
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the resource.
     */
    public function edit(Product $product)
    {
        // $product = Product::where('slug', $slug)->with('category')->first();
        $categories = Category::all();
        // dd($categories);    
        return view('admin.products.edit',['product'=> $product,'categories'=> $categories]);
    }

    /**
     * Update the resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        
        $request->validated();
        $oldImagePath = $product->image;
        $newPath = $request->image ? $request->image->store('products','public') : $oldImagePath;
        $product->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'image' => $newPath,
            'featured' => $request->featured ? true : false,
        ]);
        if($oldImagePath!== $newPath){
            Storage::disk('public')->delete($oldImagePath);
        }
        return redirect()->route('admin.product.index')->with('success','Product updated successfully');
        // dd($product);
    }

    /**
     * Remove the resource from storage.
     */
    public function destroy(Request $request,Product $product)
    {
       
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();
        return redirect()->route('admin.product.index')->with('success', 'Product deleted successfully');
    }
}
