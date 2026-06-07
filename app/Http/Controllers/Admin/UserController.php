<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::orderByDesc('created_at');

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%");
            });
        }

        if ($request->role) {
            $query->where('role', $request->role);
        }

        $users = $query->paginate(15)->withQueryString();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', Password::min(8)],
            'role'     => ['required', 'in:user,admin,superadmin'],
        ]);

        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);

        return redirect()->route('admin.users.index')
            ->with('toast_success', "User \"{$user->name}\" berhasil dibuat!");
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role'  => ['required', 'in:user,admin,superadmin'],
            'bio'   => ['nullable', 'string', 'max:500'],
        ]);

        if ($request->filled('password')) {
            $request->validate(['password' => [Password::min(8)]]);
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('toast_success', "User \"{$user->name}\" berhasil diperbarui!");
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('toast_error', 'Tidak dapat menghapus akun Anda sendiri!');
        }
        $name = $user->name;
        $user->delete();
        return redirect()->route('admin.users.index')
            ->with('toast_success', "User \"{$name}\" berhasil dihapus.");
    }

    public function show(User $user)
    {
        return redirect()->route('admin.users.index');
    }
}
