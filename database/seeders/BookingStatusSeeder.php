<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BookingStatus; // Impor model BookingStatus

class BookingStatusSeeder extends Seeder
{
    /**
     * Jalankan seeder database untuk mengisi data status peminjaman.
     */
    public function run(): void
    {
        // Menggunakan firstOrCreate untuk menghindari duplikasi jika seeder dijalankan lebih dari sekali
        BookingStatus::firstOrCreate(['id' => 1], ['name' => 'Pending TU']);
        BookingStatus::firstOrCreate(['id' => 2], ['name' => 'Diproses TU']);
        BookingStatus::firstOrCreate(['id' => 3], ['name' => 'Ditolak TU']);
        BookingStatus::firstOrCreate(['id' => 4], ['name' => 'Diserahkan ke Wadek']);
        BookingStatus::firstOrCreate(['id' => 5], ['name' => 'Diproses Wadek']);
        BookingStatus::firstOrCreate(['id' => 6], ['name' => 'Ditolak Wadek']);
        BookingStatus::firstOrCreate(['id' => 7], ['name' => 'Sukses']);
        BookingStatus::firstOrCreate(['id' => 8], ['name' => 'LPJ diperiksa']);
        BookingStatus::firstOrCreate(['id' => 9], ['name' => 'LPJ Ditolak']); 
        BookingStatus::firstOrCreate(['id' => 10], ['name' => 'Selesai']); 
        BookingStatus::firstOrCreate(['id' => 11], ['name' => 'Dibatalkan']); 
  
          }
}
