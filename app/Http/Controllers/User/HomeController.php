<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use App\Models\Admin\Product;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

class HomeController extends Controller
{
    public function index()
    {
        try {
            $featuredCategories = Category::where('featured', true)->get();
            $categories = Category::all();
            $featuredProducts = Product::where('featured', true)->paginate(4);

            return view('user.home', [
                'featuredCategories' => $featuredCategories,
                'categories' => $categories,
                'featuredProducts' => $featuredProducts
            ]);
        } catch (\Exception $e) {
            return redirect()
                ->route('home')
                ->with('error', 'Failed to load home page: ' . $e->getMessage());
        }
    }

    
}