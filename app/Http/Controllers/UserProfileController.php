<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Organization;
use Illuminate\Support\Facades\Storage;

class UserProfileController extends Controller
{
    /**
     * Menampilkan detail profil pengguna.
     */
    public function show()
    {
        $user = Auth::user()->load('role', 'organization');

        return view('user.profile.show', [
            'title' => 'Profil Petualang',
            'user' => $user,
        ]);
    }

    /**
     * Menampilkan form untuk mengedit profil pengguna.
     */
    public function edit()
    {
        $user = Auth::user()->load('organization');
        $organizations = Organization::all();

        return view('user.profile.edit', [
            'title' => 'Edit Profil Petualang',
            'user' => $user,
            'organizations' => $organizations,
        ]);
    }

    /**
     * Memproses update data profil pengguna.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'organization_id' => 'nullable|exists:organizations,id',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'required|string|min:8|confirmed';
        }

        $validatedData = $request->validate($rules);

        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->organization_id = $validatedData['organization_id'];

        if ($request->hasFile('avatar')) {
            // Hapus avatar lama kalau ada
            if ($user->avatar) {
                Storage::delete(str_replace('storage/', 'public/', $user->avatar));
            }

            $avatarPath = $request->file('avatar')->store('public/avatars');
            $user->avatar = str_replace('public/', 'storage/', $avatarPath);
        }

        if ($request->filled('password')) {
            $user->password = bcrypt($validatedData['password']);
        }

        $user->save();

        return redirect()->route('user.profile')->with('success', 'Profil berhasil diperbarui!');
    }
}
