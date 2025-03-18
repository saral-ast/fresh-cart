<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Admin\Category;
use App\Models\Admin\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Show the form for creating the resource.
     */
    public function index(Request $request){
        
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
    public function store(Request $request)
    {
       $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
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
       return redirect('admin/products');
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
    public function update(Request $request,Product $product)
    {
        
        $request->validate([
            'slug' =>'required|unique:products,slug,'.$product->id,
        ]);
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
        return redirect('admin/products');
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
        return redirect('admin/products')->with('success', 'Product deleted successfully');
    }
}
