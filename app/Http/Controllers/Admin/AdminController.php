<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdminController extends Controller
{
    /**
     * Display a listing of all admins.
     */
    public function index()
    {
        try {
            $admins = Admin::with(['role.permissions'])->get();
            // dd($admins);
            return view('admin.admins.index', compact('admins'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error fetching admins: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new admin.
     */
    public function create()
    {
        try {
            $roles = Role::all();
            return view('admin.admins.create', compact('roles'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error loading create form: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created admin in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:admin,email',
                'password' => ['required', Password::defaults()],
                'role_id' => 'required|exists:roles,id',
            ]);

            Admin::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => $request->role_id,
            ]);
            
            return redirect()->route('admin.admins.index')->with('success', 'Admin created successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error creating admin: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Show the form for editing the specified admin.
     */
    public function edit(Admin $admin)
    {
        try {
            $roles = Role::all();
            return view('admin.admins.edit', compact('admin', 'roles'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error loading edit form: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified admin in storage.
     */
    public function update(Request $request, Admin $admin)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:admin,email,' . $admin->id,
                'role_id' => 'required|exists:roles,id',
            ]);

            $admin->update([
                'name' => $request->name,
                'email' => $request->email,
                'role_id' => $request->role_id,
            ]);
            
            if ($request->filled('password')) {
                $request->validate([
                    'password' => ['required', Password::defaults()],
                ]);
                
                $admin->update([
                    'password' => Hash::make($request->password),
                ]);
            }
            
            return redirect()->route('admin.admins.index')->with('success', 'Admin updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error updating admin: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified admin from storage.
     */
    public function destroy(Admin $admin)
    {
        try {
            // Don't allow deletion of the current logged-in admin
            if ($admin->id === auth()->guard('admin')->id()) {
                return redirect()->back()->with('error', 'You cannot delete your own account.');
            }
            
            $admin->delete();
            
            return redirect()->route('admin.admins.index')->with('success', 'Admin deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error deleting admin: ' . $e->getMessage());
        }
    }
}