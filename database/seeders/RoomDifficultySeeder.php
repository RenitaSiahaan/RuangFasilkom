<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RoomDifficulty; // Impor model RoomDifficulty

class RoomDifficultySeeder extends Seeder
{
    /**
     * Jalankan seeder database untuk mengisi data tingkat kesulitan ruangan.
     */
    public function run(): void
    {
        RoomDifficulty::create(['id' => 1, 'name' => 'Beginner', 'xp_reward' => 10, 'badge_name' => 'Apprentice']);
        RoomDifficulty::create(['id' => 2, 'name' => 'Intermediate', 'xp_reward' => 25, 'badge_name' => 'Journeyman']);
        RoomDifficulty::create(['id' => 3, 'name' => 'Expert', 'xp_reward' => 75, 'badge_name' => 'Expert']);
        RoomDifficulty::create(['id' => 4, 'name' => 'Legendary', 'xp_reward' => 100, 'badge_name' => 'Legendary Master']);
    }
}