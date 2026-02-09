<?php

namespace App\Http\Controllers\Support;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin(){
        return view('support.login');
    }
    public function login(Request $request){
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!Auth::attempt($credentials)) {
            // Authentication passed...
            return back()->withErrors([
                'email' => 'Invalid credentials.',
            ]);
        }
        $user = Auth::user();
        if($user->role !=='support' || !$user->is_active){
            Auth::logout();
            return back()->withErrors([
                'email' => 'Access denied.',
            ]);
        }
        return redirect()->route(route: 'support.dashboard');
    }
    public function logout(){
        Auth::logout();
        return redirect()->route('support.login');
    }
}
