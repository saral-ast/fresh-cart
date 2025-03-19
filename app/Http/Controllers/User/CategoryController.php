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
        try{
            $categories = Category::latest()->paginate(8);
            return view('user.category.index',['categories'=>$categories]);
        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function show($slug)
    {
          try{
            $category = Category::where('slug',$slug)->with('products')->first();
            $products = $category->products()->paginate(6);
            return view('user.category.show',['products'=>$products,'category'=>$category]);
          }catch(\Exception $e){
            return response()->json([
               'success' => false,
               'message' => $e->getMessage()
            ], 500);
          }
    }

}
