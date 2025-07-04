<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RoomBooking; // Impor model RoomBooking

class HistoryController extends Controller
{
    /**
     * Menampilkan histori peminjaman ruangan pengguna yang sedang login.
     */
    public function index()
    {
        $user = Auth::user();

        // Ambil semua peminjaman ruangan milik user ini, urutkan berdasarkan waktu terbaru
        // dengan relasi room dan status dimuat
        $bookings = RoomBooking::where('user_id', $user->id)
                                ->with(['room', 'status'])
                                ->orderBy('created_at', 'desc')
                                ->get();

        return view('user.history.index', [
            'title' => 'Histori Misi (Peminjaman Ruangan)',
            'bookings' => $bookings,
        ]);
    }
}