<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function index()
    {
        return inertia('Auth/ChangePassword');
    }
    public function update(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|min:8|confirmed|different:current_password',
            'password_confirmation' => 'required',
        ],
        [
            'password.different' => 'The old password field & new password cant be same.',
        ]);
        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->save();
        return back()->with('success', 'Password Changed!');
    }

    public function create()
    {
        if (!Auth::check()) {
            return inertia('Auth/LoginPage');
        }
        return redirect()->route('dashboard.index');
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            if (!Auth::attempt($request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string'
            ]), true)) {
                throw ValidationException::withMessages([
                    'email' => 'Authentication Failed!'
                ]);
            }
            $request->session()->regenerate();
            //return redirect()->intended('/dashboard');
        }
        return redirect()->route('dashboard.index');
    }
    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
