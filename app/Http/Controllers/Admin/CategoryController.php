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
            $category->products()->delete();
            $category->delete();
            return redirect('admin/categories')->with('success', 'Category moved to trash successfully');
        }catch(\Exception $e){
            return redirect()->route('admin.categories')->with('error','Category is not deleted');
        }
    }
    
    public function trash()
    {
        try{
            $trashedCategories = Category::onlyTrashed()->latest()->paginate(5);
            return view('admin.categories.trash', ['categories' => $trashedCategories]);
        }catch(\Exception $e){
            return redirect()->route('admin.categories')->with('error','Something went wrong');
        }
    }
    
    public function restore($id)
    {
        try{
            $category = Category::onlyTrashed()->findOrFail($id);
            $category->products()->onlyTrashed()->restore();
            $category->restore();
            
            return redirect()->route('admin.categories.trash')->with('success', 'Category restored successfully');
        }catch(\Exception $e){
            return redirect()->route('admin.categories.trash')->with('error','Category could not be restored');
        }
    }
    
    public function forceDelete($id)
    {
        try{
            $category = Category::onlyTrashed()->findOrFail($id);
            
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            
            $category->forceDelete();
            
            return redirect()->route('admin.categories.trash')->with('success', 'Category permanently deleted successfully');
        }catch(\Exception $e){
            return redirect()->route('admin.categories.trash')->with('error','Category could not be permanently deleted');
        }
    }
}
