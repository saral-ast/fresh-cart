<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Show the form for creating the resource.
     */
    public function index()
    {
       
        $categories = Category::latest()->paginate(5);
        // dd($categories);
        return view('admin.categories.index',['categories'=> $categories]);
    }
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store the newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'slug' => 'required|unique:categories,slug',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $category = [
            'name' => $request->name,
            'slug' => $request->slug,
            'featured' => $request->featured ? true : false,
        ];
        $category['image'] = $request->image->store('categories','public');
        // dd($category);
        Category::create($category);
        return redirect('admin/categories');
        // return redirect()->route('admin.categories.index');
        // dd($category);
    }

    /**
     * Display the resource.
     */
    /**
     * Show the form for editing the resource.
     */
    public function edit(Category $category)
    { 
        return view('admin.categories.edit',['category'=> $category]);
    }

    /**
     * Update the resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        // dd($category);
        $request->validate([
            'slug' =>'required|unique:categories,slug,'.$category->id,
        ]);
        $oldImagePath = $category->image;
        $newPath = $request->image ? $request->image->store('categories','public') : $oldImagePath;
        $category->update([
            'name' => request('name'),
            'slug' => request('slug'),
            'image' => $newPath,
            'featured' => request('featured')? true : false,
        ]);

        if($oldImagePath !== $newPath){
            Storage::disk('public')->delete($oldImagePath);
        }        
        return redirect('admin/categories');
    }

    /**
     * Remove the resource from storage.
     */
    public function destroy(Category $category)
    { 
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }   
        $category->delete();
        
        return redirect('admin/categories')->with('success', 'Category deleted successfully');
    }
}
