<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage; // Untuk menghapus avatar

class ManageUsersController extends Controller
{
    /**
     * Menampilkan daftar semua pengguna.
     */
    public function index()
    {
        $users = User::with('role', 'organization')->orderBy('name')->get();
        return view('dashboard.admin.users.index', [
            'title' => 'Manajemen Pengguna',
            'users' => $users,
        ]);
    }

    /**
     * Menampilkan form untuk membuat pengguna baru.
     */
    public function create()
    {
        $roles = Role::all();
        $organizations = Organization::all();
        return view('dashboard.admin.users.create', [
            'title' => 'Tambah Pengguna Baru',
            'roles' => $roles,
            'organizations' => $organizations,
        ]);
    }

    /**
     * Menyimpan pengguna baru ke database.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
            'organization_id' => 'nullable|exists:organizations,id',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'xp' => 'nullable|integer|min:0',
        ]);

        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('public/avatars');
            $avatarPath = str_replace('public/', 'storage/', $avatarPath);
        }

        User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'role_id' => $validatedData['role_id'],
            'organization_id' => $validatedData['organization_id'],
            'avatar' => $avatarPath,
            'xp' => $validatedData['xp'] ?? 0,
        ]);

        return redirect()->route('dashboard.users.index')->with('success', 'Pengguna berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk mengedit pengguna.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        $organizations = Organization::all();
        return view('dashboard.admin.users.edit', [
            'title' => 'Edit Pengguna: ' . $user->name,
            'user' => $user,
            'roles' => $roles,
            'organizations' => $organizations,
        ]);
    }

    /**
     * Memperbarui data pengguna di database.
     */
    public function update(Request $request, User $user)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role_id' => 'required|exists:roles,id',
            'organization_id' => 'nullable|exists:organizations,id',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'xp' => 'nullable|integer|min:0',
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'string|min:8|confirmed';
        }

        $validatedData = $request->validate($rules);

        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->role_id = $validatedData['role_id'];
        $user->organization_id = $validatedData['organization_id'];
        $user->xp = $validatedData['xp'] ?? 0;

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::delete(str_replace('storage/', 'public/', $user->avatar));
            }
            $avatarPath = $request->file('avatar')->store('public/avatars');
            $user->avatar = str_replace('public/', 'storage/', $avatarPath);
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($validatedData['password']);
        }

        $user->save();

        return redirect()->route('dashboard.users.index')->with('success', 'Pengguna berhasil diperbarui!');
    }

    /**
     * Menghapus pengguna dari database.
     */
    public function destroy(User $user)
    {
        // Pastikan admin tidak bisa menghapus dirinya sendiri
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        if ($user->avatar) {
            Storage::delete(str_replace('storage/', 'public/', $user->avatar));
        }
        $user->delete();

        return redirect()->route('dashboard.users.index')->with('success', 'Pengguna berhasil dihapus!');
    }
}