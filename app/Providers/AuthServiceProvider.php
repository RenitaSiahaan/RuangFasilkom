<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate; // Pastikan ini diimpor
use App\Models\User; // Impor model User jika belum

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Peta kebijakan aplikasi untuk berbagai jenis model.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Daftarkan layanan otorisasi/autentikasi apa pun.
     */
    public function boot(): void
    {
        // Daftarkan gate untuk membatasi akses ke dashboard admin
        Gate::define('access-admin-dashboard', function (User $user) { // Gunakan type-hint User
            // Hanya pengguna dengan role_id 1 (Admin) yang diizinkan
            return $user->role_id === 1;
        });

        // Gate tambahan jika Anda ingin membedakan TU dan Wadek
        Gate::define('is-tu', function (User $user) {
            return $user->role_id === 1; 
        });

        Gate::define('is-wadek', function (User $user) {
            return $user->role_id === 1; 
        });
    }
}