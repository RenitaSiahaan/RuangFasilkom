<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Organization; // Impor model Organization

class OrganizationSeeder extends Seeder
{
    /**
     * Jalankan seeder database untuk mengisi data organisasi.
     */
    public function run(): void
    {
        Organization::create(['id' => 1, 'name' => 'Solo Player']);
        Organization::create(['id' => 2, 'name' => 'BEM']);
        Organization::create(['id' => 3, 'name' => 'HIMATIFA']);
        Organization::create(['id' => 4, 'name' => 'HIMASIFO']);
        Organization::create(['id' => 5, 'name' => 'HIMASADA']);
        Organization::create(['id' => 6, 'name' => 'HIMABISDI']);
        Organization::create(['id' => 7, 'name' => 'Komunitas']);
    }
}