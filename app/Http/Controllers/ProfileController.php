<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage; // Pastikan ini diimpor
use Illuminate\View\View;
use App\Models\Organization; // Pastikan ini diimpor jika digunakan di form edit

class ProfileController extends Controller
{
    /**
     * Display the user's profile form for editing.
     */
    public function edit(Request $request): View
    {
        return view('user.profile.edit', [ // Memanggil view dari resources/views/user/profile/edit.blade.php
            'user' => $request->user(),
            'organizations' => Organization::all(), // Mengirimkan semua organisasi ke view
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Ambil data yang sudah divalidasi dari FormRequest
        $validatedData = $request->validated();

        // 1. Tangani Unggahan Avatar
        if ($request->hasFile('avatar')) {
            // Hapus avatar lama jika ada dan bukan default
            // Pastikan 'images/default_avatar.png' adalah path default Anda di public folder
            if ($user->avatar && $user->avatar !== 'images/default_avatar.png' && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Simpan avatar baru ke folder 'avatars' di storage/app/public
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath; // Simpan path relatif ke database
        }

        // 2. Tangani Perubahan Password (jika field password diisi)
        // Penting: HASH password BARU jika ada
        if ($request->filled('password')) { // Mengecek apakah field password ada dan tidak kosong
            $user->password = bcrypt($request->password); // Hash password baru
        } else {
            // Jika field password kosong, HAPUS dari data yang akan di-fill
            // Ini mencegah kolom 'password' diisi NULL, karena kolom itu NOT NULL di DB
            unset($validatedData['password']);
        }

        // 3. Tangani Perubahan Email
        // Ini harus dilakukan setelah mengisi data, karena isDirty() perlu membandingkan
        if ($user->isDirty('email')) {
            $user->email_verified_at = null; // Set null agar perlu verifikasi ulang email
        }

        // 4. Isi data lainnya dari request (nama, email, organization_id) ke model user
        // PENTING: Lakukan ini SETELAH penanganan password (agar password tidak tertimpa null)
        // dan SETELAH avatar (jika ada)
        $user->fill($validatedData);

        $user->save(); // Simpan semua perubahan ke database

        // Redirect kembali ke halaman edit profil dengan pesan sukses
        return Redirect::route('user.profile')->with('status', 'profile-updated'); // Redirect ke halaman tampil profil, atau user.edit_profile jika ingin tetap di form edit
    }

    /**
     * Display the user's profile.
     */
    public function show(Request $request): View
    {
        return view('user.profile.show', [ // Memanggil view dari resources/views/user/profile/show.blade.php
            'user' => $request->user(),
        ]);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        // Optional: Hapus avatar pengguna jika mereka menghapus akun
        if ($user->avatar && $user->avatar !== 'images/default_avatar.png' && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}