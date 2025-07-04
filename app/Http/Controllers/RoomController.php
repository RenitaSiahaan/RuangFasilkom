<?php

namespace App\Http\Controllers;

use App\Models\Room; // Impor model Room
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Menampilkan daftar semua ruangan (dungeon).
     */
    public function index()
    {
        $rooms = Room::with('difficulty')->get(); // Ambil semua ruangan beserta tingkat kesulitannya

        return view('user.rooms.index', [
            'title' => 'Daftar Ruangan (Dungeon)',
            'rooms' => $rooms,
        ]);
    }

    /**
     * Menampilkan detail ruangan tertentu.
     */
    public function show(Room $room)
    {
        // Room sudah otomatis ditemukan oleh Route Model Binding
        // Pastikan relasi difficulty dimuat
        $room->load('difficulty');

        return view('user.rooms.show', [
            'title' => 'Detail Ruangan: ' . $room->name,
            'room' => $room,
        ]);
    }
}