<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\RolePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
{
    /**
     * Display a listing of the permissions.
     */
    public function index()
    {
        try {
            $permissions = Permission::paginate(8);
            return view('admin.permissions.index', compact('permissions'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error fetching permissions: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new permission.
     */
    public function create()
    {
        try {
            return view('admin.permissions.create');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error loading create form: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created permission in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'permission' => 'required|string|max:255|unique:permissions,permission',
            ]);

            Permission::create([
                'permission' => $request->permission,
            ]);
            
            return redirect()->route('admin.permissions.index')->with('success', 'Permission created successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error creating permission: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Show the form for editing the specified permission.
     */
    public function edit(Permission $permission)
    {
        try {
            return view('admin.permissions.edit', compact('permission'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error loading edit form: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified permission in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        try {
            $request->validate([
                'permission' => 'required|string|max:255|unique:permissions,permission,' . $permission->id,
            ]);

            $permission->update([
                'permission' => $request->permission,
            ]);
            
            return redirect()->route('admin.permissions.index')->with('success', 'Permission updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error updating permission: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified permission from storage.
     */
    public function destroy(Permission $permission)
    {
        try {
            // Check if permission is used in any role
            $permission->delete();
            
            return redirect()->route('admin.permissions.index')->with('success', 'Permission deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error deleting permission: ' . $e->getMessage());
        }
    }
} 