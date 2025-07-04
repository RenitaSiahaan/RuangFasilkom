<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Room;
use App\Models\RoomBooking;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Menampilkan dashboard utama admin.
     */
    public function index()
    {
        // Anda bisa mengambil statistik atau ringkasan data di sini
        $totalUsers = User::count();
        $totalRooms = Room::count();
        $pendingBookings = RoomBooking::whereHas('status', function($query) {
            $query->where('name', 'Pending TU'); // Pastikan nama status ini benar di DB Anda
        })->count();
        $approvedBookings = RoomBooking::whereHas('status', function($query) {
            $query->where('name', 'Sukses'); // Pastikan nama status ini benar di DB Anda
        })->count();

        // Admin dashboard tidak perlu $currentMonth atau $user (kecuali melalui Auth::user())
        return view('dashboard.admin.index', [
            'title' => 'Dashboard Admin',
            'totalUsers' => $totalUsers,
            'totalRooms' => $totalRooms,
            'pendingBookings' => $pendingBookings,
            'approvedBookings' => $approvedBookings,
        ]);
    }
}