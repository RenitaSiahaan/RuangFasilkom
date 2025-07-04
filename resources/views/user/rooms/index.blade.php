@extends('layouts.app')

@section('content')
<div x-data="{ openMap: false, slide: 0 }" class="bg-white text-gray-800 min-h-screen px-4 py-6">

    {{-- Header & Tombol Peta --}}
    <div class="flex flex-col items-center mb-8">
        <h1 class="text-4xl font-bold text-center mb-4 font-serif">🧭 Jelajahi Dungeon (Daftar Ruangan)</h1>
        <button @click="openMap = true"
            class="bg-blue-700 hover:bg-blue-800 text-white px-6 py-2 rounded-full shadow-lg text-lg font-semibold transition-all">
            🗺️ Lihat Peta Dungeon
        </button>
    </div>

    {{-- Modal Peta Denah --}}
    <div x-show="openMap"
         class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60"
         x-cloak>
        <div class="bg-white border-4 border-blue-800 rounded-xl p-6 relative w-[95%] max-w-5xl shadow-2xl text-black">
            <button @click="openMap = false"
                    class="absolute top-2 right-2 text-red-800 font-bold text-2xl hover:text-red-600">
                ✖
            </button>
            <h2 class="text-2xl font-bold mb-4 text-center font-serif">🗺️ Denah Dungeon Fasilkom</h2>

            <div class="flex items-center justify-between">
                <button @click="slide = (slide - 1 + 4) % 4"
                        class="text-3xl px-4 hover:text-gray-600">⬅️</button>

                <div class="w-full px-6">
<template x-if="slide === 0">
    <img src="{{ asset('storage/images/4.png') }}" alt="Denah 1"
         class="mx-auto rounded-lg shadow max-h-[500px]">
</template>
<template x-if="slide === 1">
    <img src="{{ asset('storage/images/1.png') }}" alt="Denah 2"
         class="mx-auto rounded-lg shadow max-h-[500px]">
</template>
<template x-if="slide === 2">
    <img src="{{ asset('storage/images/2.png') }}" alt="Denah 3"
         class="mx-auto rounded-lg shadow max-h-[500px]">
</template>
<template x-if="slide === 3">
    <img src="{{ asset('storage/images/3.png') }}" alt="Denah 4"
         class="mx-auto rounded-lg shadow max-h-[500px]">
</template>

                </div>

                <button @click="slide = (slide + 1) % 4"
                        class="text-3xl px-4 hover:text-gray-600">➡️</button>
            </div>
        </div>
    </div>

    {{-- Daftar Ruangan --}}
    @php
        $groupedRooms = $rooms->groupBy(fn($r) => $r->difficulty->name ?? 'Tidak Diketahui');
    @endphp

    @forelse($groupedRooms as $difficultyName => $roomsInLevel)
        <h2 class="text-2xl font-semibold mt-10 mb-4 border-b border-blue-600 pb-1">{{ $difficultyName }}</h2>

        <div class="flex flex-wrap gap-6">
            @foreach($roomsInLevel as $room)
                <div class="w-full sm:w-64 bg-blue-50 text-gray-900 rounded-lg shadow-lg border border-blue-300 hover:shadow-2xl transition-shadow duration-300">
                    @if($room->image)
                        <img src="{{ asset('storage/' . $room->image) }}" alt="Gambar {{ $room->name }}" class="w-full h-40 object-cover rounded-t-lg">
                    @else
                        <img src="{{ asset('images/default_room.png') }}" alt="Gambar Default Ruangan" class="w-full h-40 object-cover rounded-t-lg">
                    @endif

                    <div class="p-4">
                        <h3 class="text-lg font-bold mb-1 font-serif">{{ $room->name }}</h3>
                        <p class="text-sm">📍 Lokasi: {{ $room->location ?? '-' }}</p>
                        <p class="text-sm">👥 Kapasitas: {{ $room->capacity }} orang</p>
                        <p class="text-sm">✨ XP: {{ $room->difficulty->xp_reward ?? 0 }}</p>

                        <div class="mt-3 text-right">
                            <a href="{{ route('rooms.show', $room->id) }}"
                               class="px-4 py-1 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
                                🔍 Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @empty
        <p class="text-gray-500 italic mt-6">Tidak ada ruangan yang tersedia.</p>
    @endforelse
</div>
@endsection
