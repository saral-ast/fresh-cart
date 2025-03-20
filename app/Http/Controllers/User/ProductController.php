<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Admin\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Show the form for creating the resource.
     */
    public function index(){
        $products = Product::latest("id")->paginate(8);
        return view('user.product.index',['products'=>$products]);
    }
    public function create(): never
    {
        abort(404);
    }


    /**
     * Display the resource.
     */
    public function show($slug)
    {
        // dd($slug);
        $product = Product::where('slug',$slug)->with('category')->first();
        $relatedProducts =  Product::where('category_id',$product->category_id)->where('id','!=',$product->id)->latest()->get();
        return view('user.product.show',['product'=>$product,'relatedProducts'=>$relatedProducts]);
    }

    /**
     * Show the form for editing the resource.
     */
    public function edit()
    {
        //
    }

    /**
     * Update the resource in storage.
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the resource from storage.
     */
    public function destroy(): never
    {
        abort(404);
    }
}
