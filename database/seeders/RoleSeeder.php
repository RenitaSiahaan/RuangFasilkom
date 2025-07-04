<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role; // Impor model Role

class RoleSeeder extends Seeder
{
    /**
     * Jalankan seeder database untuk mengisi data peran (roles).
     */
    public function run(): void
    {
        Role::create(['id' => 1, 'name' => 'Admin']);
        Role::create(['id' => 2, 'name' => 'Dosen']);
        Role::create(['id' => 3, 'name' => 'Mahasiswa']);
    }
}