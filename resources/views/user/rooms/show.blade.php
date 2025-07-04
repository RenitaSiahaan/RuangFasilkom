@extends('layouts.app')

@section('content')
    <a href="{{ route('rooms.index') }}" class="inline-block text-blue-600 hover:underline mb-6">&larr; Kembali ke Daftar Ruangan</a>

    <h1 class="text-3xl font-bold mb-6 text-center">🏰 Detail Ruangan: {{ $room->name }}</h1>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden border border-gray-200">
        @if($room->image)
            <img src="{{ asset('storage/' . $room->image) }}" alt="Gambar {{ $room->name }}" class="w-full h-64 object-cover">
        @else
            <img src="{{ asset('images/default_room.png') }}" alt="Gambar Default Ruangan" class="w-full h-64 object-cover">
        @endif

        <div class="p-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-3">{{ $room->name }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700 text-lg mb-6">
                <p>📍 <strong>Lokasi:</strong> {{ $room->location ?? 'Tidak ada informasi lokasi' }}</p>
                <p>👥 <strong>Kapasitas:</strong> {{ $room->capacity }} orang</p>
                <p>⚔️ <strong>Kesulitan:</strong> <span class="font-bold text-blue-600">{{ $room->difficulty->name ?? 'Tidak Diketahui' }}</span></p>
                <p>✨ <strong>Hadiah XP:</strong> {{ $room->difficulty->xp_reward ?? 0 }} XP</p>
            </div>
            <p class="text-gray-800 mb-6">{{ $room->description ?? 'Tidak ada deskripsi untuk ruangan ini.' }}</p>

            <div class="text-center mt-6">
                <a href="{{ route('room_bookings.create', $room->id) }}"
                   class="inline-block px-8 py-3 bg-green-600 text-white text-lg font-semibold rounded-lg shadow-md hover:bg-green-700 transition duration-300">
                    📅 Pesan Ruangan Ini
                </a>
            </div>
        </div>
    </div>
@endsection
