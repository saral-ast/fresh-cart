<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AdminLoginController extends Controller
{
    public function create()
    {
        try {
            return view('auth.admin-login');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.login')
                ->with('error', 'Failed to load login page: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            if (!Auth::guard('admin')->attempt($credentials)) {
                throw ValidationException::withMessages([
                    'email' => 'Your provided credentials could not be verified.',
                ]);
            }

            $request->session()->regenerate();
            return redirect()
                ->route('admin.dashboard')
                ->with('success', 'Successfully logged in as admin.');
        } catch (ValidationException $e) {
            throw $e; // Re-throw validation exceptions to maintain Laravel's default behavior
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.login')
                ->with('error', 'Login failed: ' . $e->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        try {
            Auth::guard('admin')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('admin.login')
                ->with('success', 'Successfully logged out.');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.login')
                ->with('error', 'Logout failed: ' . $e->getMessage());
        }
    }
}