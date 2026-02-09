<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required','email'],
            'password' => ['required'],
        ]);

        if (!Auth::attempt($credentials)) {
            return back()->withErrors(['email' => 'Invalid credentials']);
        }

        $user = Auth::user();

        if ($user->role !== 'admin') {
            Auth::logout();
            return back()->withErrors(['email' => 'Access denied']);
        }

        return redirect()->route('admin.users');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.login');
    }
}
