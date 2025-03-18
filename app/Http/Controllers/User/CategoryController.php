<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use App\Models\Admin\Product;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class CategoryController extends Controller
{
    /**
     * Show the form for creating the resource.
     */
    public function index(){
        $categories = Category::latest()->paginate(8);
        return view('user.category.index',['categories'=>$categories]);
    }
    public function create(): never
    {
        abort(404);
    }

    /**
     * Store the newly created resource in storage.
     */
    public function store(Request $request): never
    {
        abort(404);
    }

    /**
     * Display the resource.
     */
    public function show($slug)
    {
          $category = Category::where('slug',$slug)->with('products')->first();
          $products = $category->products()->paginate(6);
        //   $products = Product::where('category_id', $category->id)->paginate(2);
          return view('user.category.show',['products'=>$products,'category'=>$category]);
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
