<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
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
        try{
            $categories = Category::latest()->paginate(5);
        // dd($categories);
        return view('admin.categories.index',['categories'=> $categories]);
        }catch(\Exception $e){
            return redirect()->route('admin.categories')->with('error','Something went wrong');
        }
    }
    public function create()
    {
        try{
            return view('admin.categories.create');
        }catch(\Exception $e){
            return redirect()->route('admin.categories')->with('error','Something went wrong');
        }
       
    }

    /**
     * Store the newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        try{
            // dd($request->all());
        $request->validated();
        $category = [
            'name' => $request->name,
            'slug' => $request->slug,
            'featured' => $request->featured ? true : false,
        ];
        $category['image'] = $request->image->store('categories','public');
        // dd($category);
        Category::create($category);
        return redirect()->route('admin.categories')->with('success','Category created successfully');
        // return redirect()->route('admin.categories.index');
        // dd($category);
        }catch(\Exception $e){
            return redirect()->route('admin.categories')->with('error','The Category is not stored');
        }
    }

    /**
     * Display the resource.
     */
    /**
     * Show the form for editing the resource.
     */
    public function edit(Category $category)
    { 
        try{
            return view('admin.categories.edit',['category'=> $category]);
        }catch(\Exception $e){
            return redirect()->route('admin.categories')->with('error','Something went wrong');
        }
    }

    /**
     * Update the resource in storage.
     */
    public function update(CategoryRequest $request, Category $category)
    {
        // dd($category);
        try{
            $request->validated();
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
            return redirect()->route('admin.categories')->with('success','Category updated successfully');
        }catch(\Exception $e){
            return redirect()->route('admin.categories')->with('error','Category is not updated');
        }
    }

    /**
     * Remove the resource from storage.
     */
    public function destroy(Category $category)
    { 
        try{
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }   
            $category->delete();
            
            return redirect('admin/categories')->with('success', 'Category deleted successfully');
        }catch(\Exception $e){
            return redirect()->route('admin.categories')->with('error','Category is not deleted');
        }
    }
}
