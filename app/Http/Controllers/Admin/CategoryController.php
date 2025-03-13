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
        $categories = Category::latest()->simplePaginate(10);
        // dd($categories);
        return view('admin.categories.index',['categories' => $categories]);
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
        ];
        $category['image'] = $request->image->store('categories','public');
        Category::create($category);
        return redirect('admin/categories');
        // return redirect()->route('admin.categories.index');
        // dd($category);
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
    public function edit($slug)
    {
        $category = Category::where('slug', $slug)->first();
        return view('admin.categories.edit',['category'=> $category]);
    }

    /**
     * Update the resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'slug' =>'required|unique:categories,slug,'.$id,
        ]);
        $category = Category::find($id);
        $oldImagePath = $category->image;
        $newPath = $request->image ? $request->image->store('categories','public') : $oldImagePath;
        $category->update([
            'name' => request('name'),
            'slug' => request('slug'),
            'image' => $newPath,
        ]);

        if($oldImagePath !== $newPath){
            Storage::disk('public')->delete($oldImagePath);
        }        
        return redirect('admin/categories');
    }

    /**
     * Remove the resource from storage.
     */
    public function destroy($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }
        
        $category->delete();
        
        return redirect('admin/categories')->with('success', 'Category deleted successfully');
    }
}
