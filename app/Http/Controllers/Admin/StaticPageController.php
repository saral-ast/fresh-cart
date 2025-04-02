<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\StaticPage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StaticPageController extends Controller
{
    public function index()
    {
        try {
            $staticPages = StaticPage::paginate(10);
            return view('admin.static-pages.index', compact('staticPages'));
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.static-pages.index')
                ->with('error', 'Failed to load static pages: ' . $e->getMessage());
        }
    }

    public function create()
    {
        try {
            // dd('sdfsd');
            return view('admin.static-pages.create');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.static-pages.index')
                ->with('error', 'Failed to load create form: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:static_pages,slug',
                'content' => 'required',
                'is_active' => 'boolean'
            ]);

            StaticPage::create([
                'title' => $request->title,
                'slug' => $request->slug,
                'content' => $request->content,
                'is_active' => $request->has('is_active') ? 1 : 0
            ]);

            return redirect()
                ->route('admin.static-pages.index')
                ->with('success', 'Static page created successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.static-pages.index')
                ->with('error', 'Failed to create static page: ' . $e->getMessage());
        }
    }

    public function edit(StaticPage $staticPage)
    {
        try {
            return view('admin.static-pages.edit', compact('staticPage'));
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.static-pages.index')
                ->with('error', 'Failed to load edit form: ' . $e->getMessage());
        }
    }

    public function update(Request $request, StaticPage $staticPage)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:static_pages,slug,' . $staticPage->id,
                'content' => 'required',
                'is_active' => 'boolean'
            ]);

            $staticPage->update([
                'title' => $request->title,
                'slug' => $request->slug,
                'content' => $request->content,
                'is_active' => $request->has('is_active') ? 1 : 0
            ]);

            return redirect()
                ->route('admin.static-pages.index')
                ->with('success', 'Static page updated successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.static-pages.index')
                ->with('error', 'Failed to update static page: ' . $e->getMessage());
        }
    }

    public function destroy(StaticPage $staticPage)
    {
        try {
            $staticPage->delete();

            return redirect()
                ->route('admin.static-pages.index')
                ->with('success', 'Static page deleted successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.static-pages.index')
                ->with('error', 'Failed to delete static page: ' . $e->getMessage());
        }
    }
}