<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    private function ensureAdmin(Request $request)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json(['message' => 'Forbidden'], 403);
        }
    }
    public function createUser(Request $request)
    {
        $adminCheck = $this->ensureAdmin($request);
        if ($adminCheck) {
            return $adminCheck;
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,support,customer',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

        return response()->json(['user' => $user], 201);
    }
    //list users 
    public function listUsers(Request $request)
    {
        $adminCheck = $this->ensureAdmin($request);
        if ($adminCheck) {
            return $adminCheck;
        }

        // $users = User::all();
        // return response()->json(['users' => $users]);
        
        $query = User::query()->select('id', 'name', 'email', 'role', 'is_active', 'created_at')->orderByDesc('created_at');
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        return response()->json(['users' => $query->paginate(20)]);
    }
    //enable/disable user
    public function setActive(Request $request, User $user)
    {
        $adminCheck = $this->ensureAdmin($request);
        if ($adminCheck) {
            return $adminCheck;
        }

        $data = $request->validate([
            'is_active' => ['required|boolean'],
        ]);
        
        
        if($user->id === $request->user()->id && $data['is_active'] === false){
            return response()->json(['message' => 'You Cannot Disable Yourself'], 409);
           
        }
        $user->is_active = $data['is_active'];
        $user->save();
        return response()->json(['user' => [
            'id'=>$user->id,
            'name'=>$user->name,
            'email' => $user->email,
            'role' => $user->role,
            'is_active' => $user->is_active,
        ]]);
    }
    // Admin: reset password (returns new password once)
    public function resetPassword(Request $request, User $user)
    {
        $this->ensureAdmin($request);

        $data = $request->validate([
            'password' => ['nullable','string','min:6','max:50'],
        ]);

        $plainPassword = $data['password'] ?? Str::password(10);

        $user->password = Hash::make($plainPassword);
        $user->save();

        return response()->json([
            'message' => 'Password reset',
            'generated_password' => $plainPassword,
        ]);
    }

}
