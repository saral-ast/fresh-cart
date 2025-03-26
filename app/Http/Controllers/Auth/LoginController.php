<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function create()
    {
        try {
            return view('auth.login');
        } catch (\Exception $e) {
            return redirect()
                ->route('home')
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

            $user = User::where('email', $request->email)->first();

            if (!$user || !Auth::guard('user')->attempt($credentials)) {
                throw ValidationException::withMessages([
                    'email' => 'The provided credentials do not match our records.',
                ]);
            }

            if ($user->status !== 'active') {
                Auth::guard('user')->logout(); // Logout if somehow authenticated
                throw ValidationException::withMessages([
                    'email' => 'Your account is not active.',
                ]);
            }

            $request->session()->regenerate();

            return redirect()
                ->route('home')
                ->with('success', 'Successfully logged in.');
        } catch (ValidationException $e) {
            throw $e; // Re-throw validation exceptions for Laravel's default handling
        } catch (\Exception $e) {
            return redirect()
                ->route('login')
                ->with('error', 'Login failed: ' . $e->getMessage());
        }
    }

    public function destroy()
    {
        try {
            Auth::guard('user')->logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();

            return redirect()
                ->route('home')
                ->with('success', 'Successfully logged out.');
        } catch (\Exception $e) {
            return redirect()
                ->route('home')
                ->with('error', 'Logout failed: ' . $e->getMessage());
        }
    }
}