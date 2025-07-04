<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\RoomDifficulty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Pastikan ini ada untuk operasi Storage

class ManageRoomsController extends Controller
{
    /**
     * Menampilkan daftar semua ruangan.
     */
    public function index()
    {
        $rooms = Room::with('difficulty')->orderBy('name')->get();
        return view('dashboard.admin.rooms.index', [
            'title' => 'Manajemen Ruangan',
            'rooms' => $rooms,
        ]);
    }

    /**
     * Menampilkan form untuk membuat ruangan baru.
     */
    public function create()
    {
        $difficulties = RoomDifficulty::all();
        return view('dashboard.admin.rooms.create', [
            'title' => 'Tambah Ruangan Baru',
            'difficulties' => $difficulties,
        ]);
    }

    /**
     * Menyimpan ruangan baru ke database.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'capacity' => 'required|integer|min:0',
            'difficulty_id' => 'required|exists:room_difficulties,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Maks 2MB
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            // Menggunakan Storage::disk('public')->store() akan menyimpan file di
            // storage/app/public/rooms dan mengembalikan path relatif seperti 'rooms/namafile.jpg'.
            // Path inilah yang akan disimpan di database.
            $imagePath = $request->file('image')->store('rooms', 'public');
        }

        Room::create([
            'name' => $validatedData['name'],
            'location' => $validatedData['location'],
            'description' => $validatedData['description'],
            'capacity' => $validatedData['capacity'],
            'difficulty_id' => $validatedData['difficulty_id'],
            'image' => $imagePath, // Simpan path relatif ke database
        ]);

        return redirect()->route('dashboard.rooms.index')->with('success', 'Ruangan berhasil ditambahkan!');
    }

    /**
     * Menampilkan detail ruangan (biasanya tidak langsung di dashboard admin, tapi bisa di-reuse).
     */
    public function show(Room $room)
    {
        return view('dashboard.admin.rooms.show', [
            'title' => 'Detail Ruangan: ' . $room->name,
            'room' => $room->load('difficulty'),
        ]);
    }

    /**
     * Menampilkan form untuk mengedit ruangan.
     */
    public function edit(Room $room)
    {
        $difficulties = RoomDifficulty::all();
        return view('dashboard.admin.rooms.edit', [
            'title' => 'Edit Ruangan: ' . $room->name,
            'room' => $room,
            'difficulties' => $difficulties,
        ]);
    }

    /**
     * Memperbarui data ruangan di database.
     */
    public function update(Request $request, Room $room)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'capacity' => 'required|integer|min:0',
            'difficulty_id' => 'required|exists:room_difficulties,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        $validatedData = $request->validate($rules);

        $room->name = $validatedData['name'];
        $room->location = $validatedData['location'];
        $room->description = $validatedData['description'];
        $room->capacity = $validatedData['capacity'];
        $room->difficulty_id = $validatedData['difficulty_id'];

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada dan file-nya benar-benar ada di storage
            // $room->image diharapkan berisi path relatif dari storage/app/public (e.g., 'rooms/old_image.jpg')
            if ($room->image && Storage::disk('public')->exists($room->image)) {
                Storage::disk('public')->delete($room->image);
            }

            // Simpan gambar baru ke storage/app/public/rooms
            // $imagePath akan berisi path relatif, e.g., 'rooms/new_image.jpg'
            $imagePath = $request->file('image')->store('rooms', 'public');
            $room->image = $imagePath; // Perbarui kolom 'image' di database dengan path baru
        }
        // Jika tidak ada file baru yang diunggah, kolom 'image' tidak akan berubah,
        // yang merupakan perilaku yang diinginkan.

        $room->save();

        return redirect()->route('dashboard.rooms.index')->with('success', 'Ruangan berhasil diperbarui!');
    }

    /**
     * Menghapus ruangan dari database.
     */
    public function destroy(Room $room)
    {
        // Hapus gambar terkait dari storage jika ada dan file-nya benar-benar ada
        // $room->image diharapkan berisi path relatif dari storage/app/public
        if ($room->image && Storage::disk('public')->exists($room->image)) {
            Storage::disk('public')->delete($room->image);
        }
        $room->delete();

        return redirect()->route('dashboard.rooms.index')->with('success', 'Ruangan berhasil dihapus!');
    }
}