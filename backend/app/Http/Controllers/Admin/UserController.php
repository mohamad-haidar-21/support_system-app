<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderByDesc('created_at')->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string'],
            'email' => ['required','email','unique:users,email'],
            'role' => ['required', Rule::in(['customer','support'])],
        ]);

        $password = Str::password(8);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => $data['role'],
            'is_active' => true,
            'password' => Hash::make($password),
        ]);

        return back()->with('success', "User created. Password: $password");
    }

    public function toggle(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->withErrors('You cannot disable yourself');
        }

        $user->is_active = !$user->is_active;
        $user->save();

        return back();
    }
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->withErrors('You cannot delete yourself');
        }

        $user->delete();

        return back()->with('success', 'User deleted');
    }
}
