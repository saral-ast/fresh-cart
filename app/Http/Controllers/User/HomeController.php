<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use App\Models\Admin\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the form for creating the resource.
     */
    public function index(){
        $featuredCategories = Category::where('featured', true)->get();
        $categories = Category::all();
        $featuredProducts = Product::where('featured', true)->paginate(4);
        
        return view("user.home",['featuredCategories' => $featuredCategories, 'categories' => $categories, 'featuredProducts' => $featuredProducts]);
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
    public function show()
    {
        //
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
