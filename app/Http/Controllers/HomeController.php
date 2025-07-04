<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\RoomBooking; // Pastikan model RoomBooking di-import
use App\Models\User; // Pastikan model User di-import jika digunakan untuk relasi
use App\Models\Room; // Pastikan model Room di-import jika digunakan untuk relasi
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Menampilkan halaman utama dengan kalender peminjaman.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $user = Auth::user(); // Mengambil data user yang sedang login

        // Mengambil bulan dan tahun dari request, default ke bulan dan tahun sekarang
        $displayMonth = $request->input('month', Carbon::now()->month);
        $displayYear = $request->input('year', Carbon::now()->year);

        // Buat objek Carbon untuk bulan yang ditampilkan di kalender
        $currentMonth = Carbon::create($displayYear, $displayMonth, 1);

        // Ambil semua peminjaman yang berstatus 'Sukses' untuk bulan ini
        // Menggunakan with() untuk eager loading relasi yang dibutuhkan
        $allApprovedBookings = RoomBooking::whereHas('status', function ($query) {
            $query->where('name', 'Sukses'); // Menggunakan 'Sukses' sesuai seeder terbaru
        })
        ->whereYear('start_time', $currentMonth->year)
        ->whereMonth('start_time', $currentMonth->month)
        ->with(['user', 'room']) // Eager load relasi room dan user
        ->orderBy('start_time')
        ->get();

        // Format data untuk kalender agar sesuai dengan struktur Alpine.js di view
        $approvedBookings = $allApprovedBookings->groupBy(function($booking) {
            return Carbon::parse($booking->start_time)->format('Y-m-d'); // Kelompokkan berdasarkan tanggal mulai
        })
        ->map(function ($bookingsOnDate) {
            return $bookingsOnDate->map(function ($booking) {
                // Format tanggal dan waktu secara eksplisit untuk Alpine.js di modal
                $startTimeFormatted = Carbon::parse($booking->start_time)->format('H:i'); // cth: "09:00"
                $endTimeFormatted = Carbon::parse($booking->end_time)->format('H:i');   // cth: "11:00"
                $startDateFormatted = Carbon::parse($booking->start_time)->format('d F Y'); // cth: "25 Juni 2025"
                $endDateFormatted = Carbon::parse($booking->end_time)->format('d F Y');   // cth: "25 Juni 2025"

                return [
                    'id' => $booking->id,
                    'room' => $booking->room->name ?? 'N/A', // Nama ruangan dari relasi
                    'borrower' => $booking->user->name ?? 'N/A', // Nama peminjam dari relasi
                    'purpose' => $booking->purpose,
                    'notes' => $booking->notes ?? 'Tidak ada catatan.', // Jika ada kolom notes
                    'time' => "{$startTimeFormatted} - {$endTimeFormatted}", // Untuk ringkasan hari ini
                    'start_date' => $startDateFormatted, // Untuk button kalender (d F Y)
                    'end_date' => $endDateFormatted,     // Untuk button kalender (d F Y)
                    'start_time_formatted' => $startTimeFormatted, // Untuk detail modal Alpine.js
                    'end_time_formatted' => $endTimeFormatted,   // Untuk detail modal Alpine.js
                    'start_date_formatted' => $startDateFormatted, // Untuk detail modal Alpine.js
                    'end_date_formatted' => $endDateFormatted,     // Untuk detail modal Alpine.js
                    // Tambahkan data lain yang mungkin relevan untuk detail modal jika diperlukan
                ];
            });
        })
        ->toArray(); // Konversi koleksi menjadi array

        // Menggunakan 'user.home' karena file view Anda berada di resources/views/user/home.blade.php
        return view('user.home', compact('user', 'approvedBookings', 'currentMonth'));
    }
}
