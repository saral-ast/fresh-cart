<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use App\Models\Admin\Product;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class CategoryController extends Controller
{
    public function getWithCount()
    {
        try {
            $categories = Category::withCount('products')
                ->having('products_count', '>', 0)
                ->get()
                ->map(function ($category) {
                    return [
                        'id' => $category->id,
                        'name' => $category->name,
                        'slug' => $category->slug,
                        'count' => $category->products_count
                    ];
                });

            return response()->json([
                'success' => true,
                'categories' => $categories
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

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
