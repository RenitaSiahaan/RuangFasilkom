<?php
namespace Database\Seeders;

use App\Models\User; // Impor model User
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Jalankan seeder database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            OrganizationSeeder::class,
            RoomDifficultySeeder::class,
            BookingStatusSeeder::class,
            RoomSeeder::class, // Pastikan RoomSeeder dipanggil setelah RoomDifficultySeeder
        ]);

        // Buat user admin, dosen, dan mahasiswa contoh
        User::factory()->create([
            'name' => 'Admin Utama',
            'email' => 'admin@example.com',
            'role_id' => 1, // ID untuk Admin dari RoleSeeder
            'organization_id' => 4, // ID untuk Solo Player dari OrganizationSeeder
        ]);

        User::factory()->create([
            'name' => 'Dosen Contoh',
            'email' => 'dosen@example.com',
            'role_id' => 2, // ID untuk Dosen dari RoleSeeder
            'organization_id' => 4, // ID untuk Solo Player
        ]);

        User::factory()->create([
            'name' => 'Mahasiswa Contoh',
            'email' => 'mahasiswa@example.com',
            'role_id' => 3, // ID untuk Mahasiswa dari RoleSeeder
            'organization_id' => 1, // ID untuk HIMA (contoh)
        ]);
    }
}