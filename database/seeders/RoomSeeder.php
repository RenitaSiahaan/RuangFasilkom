<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;
use App\Models\RoomDifficulty;

class RoomSeeder extends Seeder
{
    /**
     * Jalankan seeder database untuk mengisi data ruangan.
     */
    public function run(): void
    {
        $beginner = RoomDifficulty::where('name', 'Beginner')->first()->id;
        $intermediate = RoomDifficulty::where('name', 'Intermediate')->first()->id;
        $expert = RoomDifficulty::where('name', 'Expert')->first()->id;
        $legendary = RoomDifficulty::where('name', 'Legendary')->first()->id;

        Room::create([
            'name' => 'Ruang Kelas 301',
            'location' => 'Gedung FIK 1, Lantai 3',
            'description' => 'Ruang kelas standar dengan proyektor dan papan tulis.',
            'capacity' => 40,
            'difficulty_id' => $beginner,
            'image' => 'rooms/Beginner.png',
        ]);

            Room::create([
            'name' => 'Ruang Kelas FIK 302',
            'location' => 'Gedung FIK 1, Lantai 3',
            'description' => 'Ruang kelasNdengan AC, proyektor dan papan tulis.',
            'capacity' => 40,
            'difficulty_id' => $beginner,
            'image' => 'rooms/Beginner.png',
        ]);

             Room::create([
            'name' => 'Ruang Kelas FIK 303',
            'location' => 'Gedung FIK 1, Lantai 3',
            'description' => 'Ruang kelas dengan AC, proyektor dan papan tulis.',
            'capacity' => 40,
            'difficulty_id' => $beginner,
            'image' => 'rooms/Beginner.png',
        ]);

        Room::create([
            'name' => 'Ruang Kelas FIK 101',
            'location' => 'Gedung FIK 2, Lantai 1',
            'description' => 'Ruang kelas dengan AC, proyektor dan papan tulis.',
            'capacity' => 60,
            'difficulty_id' => $intermediate,
            'image' => 'rooms/Intermediate.png',
        ]);

            Room::create([
            'name' => 'Ruang Kelas FIK 102',
            'location' => 'Gedung FIK 2, Lantai 1',
            'description' => 'Ruang kelas dengan AC, proyektor dan papan tulis.',
            'capacity' => 60,
            'difficulty_id' => $intermediate,
            'image' => 'rooms/Intermediate.png',
        ]);

            Room::create([
            'name' => 'Ruang Kelas FIK 204',
            'location' => 'Gedung FIK 2, Lantai 2',
            'description' => 'Ruang kelas modern dengan smartboard dan AC.',
            'capacity' => 30,
            'difficulty_id' => $intermediate,
            'image' => 'rooms/Intermediate.png',
        ]);

            Room::create([
            'name' => 'Ruang Kelas FIK 205',
            'location' => 'Gedung FIK 2, Lantai 2',
            'description' => 'Ruang kelas modern dengan smartboard dan AC.',
            'capacity' => 50,
            'difficulty_id' => $intermediate,
            'image' => 'rooms/Intermediate.png',
        ]);

            Room::create([
            'name' => 'Ruang Kelas FIK 301',
            'location' => 'Gedung FIK 2, Lantai 3',
            'description' => 'Ruang kelas modern dengan smartboard dan AC.',
            'capacity' => 60,
            'difficulty_id' => $intermediate,
            'image' => 'rooms/Intermediate.png',
        ]);

            Room::create([
            'name' => 'Ruang Kelas FIK 302',
            'location' => 'Gedung FIK 2, Lantai 3',
            'description' => 'Ruang kelas modern dengan smartboard dan AC.',
            'capacity' => 60,
            'difficulty_id' => $intermediate,
            'image' => 'rooms/Intermediate.png',
        ]);

        Room::create([
            'name' => 'Ruang Seminar',
            'location' => 'Gedung FIK 2, Lantai 3',
            'description' => 'Ruang Seminar dengan double proyektor, kursi, AC, dan sound system.',
            'capacity' => 300,
            'difficulty_id' => $expert,
            'image' => 'rooms/Expert.png', // Contoh nama file gambar
        ]);

            Room::create([
            'name' => 'Laboratorium Informatika',
            'location' => 'Gedung FIK 2, Lantai 2',
            'description' => 'Lab khusus untuk penelitian dan proyek komputasi berat.',
            'capacity' => 50,
            'difficulty_id' => $legendary,
            'image' => 'images/rooms/lab_komputasi.jpg',
        ]);

             Room::create([
            'name' => 'Laboratorium Bisnis Digital',
            'location' => 'Gedung FIK 2, Lantai 2',
            'description' => 'Lab khusus untuk penelitian dan proyek komputasi berat.',
            'capacity' => 50,
            'difficulty_id' => $legendary,
            'image' => 'images/rooms/lab_komputasi.jpg',
        ]);
    }
}