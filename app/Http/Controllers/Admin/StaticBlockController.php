<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\StaticBlock;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StaticBlockController extends Controller
{
    public function index()
    {
        try {
            $staticBlocks = StaticBlock::paginate(10);
            // dd($staticBlocks);
            return view('admin.static-blocks.index', compact('staticBlocks'));
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.static-blocks.index')
                ->with('error', 'Failed to load static blocks: ' . $e->getMessage());
        }
    }

    public function create()
    {
        try {
            return view('admin.static-blocks.create');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.static-blocks.index')
                ->with('error', 'Failed to load create form: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'identifier' => 'required|string|max:255|unique:static_blocks,identifier',
                'content' => 'required',
                'is_active' => 'boolean'
            ]);

            StaticBlock::create([
                'title' => $request->title,
                'identifier' => $request->identifier,
                'content' => $request->content,
                'is_active' => $request->has('is_active') ? 1 : 0
            ]);

            return redirect()
                ->route('admin.static-blocks.index')
                ->with('success', 'Static block created successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.static-blocks.index')
                ->with('error', 'Failed to create static block: ' . $e->getMessage());
        }
    }

    public function edit(StaticBlock $staticBlock)
    {
        try {
            return view('admin.static-blocks.edit', compact('staticBlock'));
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.static-blocks.index')
                ->with('error', 'Failed to load edit form: ' . $e->getMessage());
        }
    }

    public function update(Request $request, StaticBlock $staticBlock)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'identifier' => 'required|string|max:255|unique:static_blocks,identifier,' . $staticBlock->id,
                'content' => 'required',
                'is_active' => 'boolean'
            ]);

            $staticBlock->update([
                'title' => $request->title,
                'identifier' => $request->identifier,
                'content' => $request->content,
                'is_active' => $request->has('is_active') ? 1 : 0
            ]);

            return redirect()
                ->route('admin.static-blocks.index')
                ->with('success', 'Static block updated successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.static-blocks.index')
                ->with('error', 'Failed to update static block: ' . $e->getMessage());
        }
    }

    public function destroy(StaticBlock $staticBlock)
    {
        try {
            $staticBlock->delete();
            
            return redirect()
                ->route('admin.static-blocks.index')
                ->with('success', 'Static block deleted successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.static-blocks.index')
                ->with('error', 'Failed to delete static block: ' . $e->getMessage());
        }
    }
}