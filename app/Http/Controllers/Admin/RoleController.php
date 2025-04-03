<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /**
     * Display a listing of the roles.
     */
    public function index()
    {
        try {
            // dd('sdfs');
            $roles = Role::all();
            // dd($roles);
            return view('admin.roles.index', compact('roles'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error fetching roles: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new role.
     */
    public function create()
    {
        try {
            $permissions = Permission::all();
            return view('admin.roles.create', compact('permissions'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error loading create form: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created role in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'roles' => 'required|string|max:255|unique:roles,roles',
                'permissions' => 'required|array',
                'permissions.*' => 'exists:permissions,id',
            ]);

            DB::beginTransaction();
            
            $role = Role::create([
                'roles' => $request->roles,
            ]);

            foreach ($request->permissions as $permissionId) {
                RolePermission::create([
                    'role_if' => $role->id,
                    'permission_id' => $permissionId,
                ]);
            }

            DB::commit();
            
            return redirect()->route('admin.roles.index')->with('success', 'Role created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error creating role: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Show the form for editing the specified role.
     */
    public function edit(Role $role)
    {
        try {
            // dd($role);
            $permissions = Permission::all();
            $rolePermissions = $role->permissions->pluck('id')->toArray();
            
            return view('admin.roles.edit', compact('role', 'permissions', 'rolePermissions'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error loading edit form: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified role in storage.
     */
    public function update(Request $request, Role $role)
    {
        try {
            $request->validate([
                'roles' => 'required|string|max:255|unique:roles,roles,' . $role->id,
                'permissions' => 'required|array',
                'permissions.*' => 'exists:permissions,id',
            ]);

            DB::beginTransaction();
            
            $role->update([
                'roles' => $request->roles,
            ]);

            // Delete existing permissions for this role
            RolePermission::where('role_if', $role->id)->delete();
            
            // Add new permissions
            foreach ($request->permissions as $permissionId) {
                RolePermission::create([
                    'role_if' => $role->id,
                    'permission_id' => $permissionId,
                ]);
            }

            DB::commit();
            
            return redirect()->route('admin.roles.index')->with('success', 'Role updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error updating role: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified role from storage.
     */
    public function destroy(Role $role)
    {
        try {
            // Check if role is assigned to any admin
            $adminCount = \App\Models\Admin::where('role_id', $role->id)->count();
            
            if ($adminCount > 0) {
                return redirect()->back()->with('error', 'Cannot delete role. It is assigned to ' . $adminCount . ' admin(s).');
            }
            
            DB::beginTransaction();
            
            // Delete related permissions
            RolePermission::where('role_if', $role->id)->delete();
            
            // Delete the role
            $role->delete();
            
            DB::commit();
            
            return redirect()->route('admin.roles.index')->with('success', 'Role deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error deleting role: ' . $e->getMessage());
        }
    }
} 