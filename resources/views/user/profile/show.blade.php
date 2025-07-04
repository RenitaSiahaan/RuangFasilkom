@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <a href="{{ route('home') }}" class="inline-block text-blue-600 hover:underline mb-6">&larr; Kembali ke Home</a>

    <h1 class="text-3xl font-bold mb-6 text-center">Profil Petualang Anda</h1>

    <div class="bg-white rounded-lg shadow-lg p-8 border border-gray-200 text-center">

        {{-- Avatar dan Bingkai --}}
        <div class="relative w-48 h-48 mx-auto mb-4">
            {{-- Avatar --}}
            @if($user->avatar)
                <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar Pengguna"
                     class="absolute inset-0 w-32 h-32 rounded-full object-cover border-4 border-blue-300 shadow-md z-10"
                     style="top: 50%; left: 50%; transform: translate(-50%, -50%);">
            @else
                <img src="{{ asset('images/default_avatar.png') }}" alt="Avatar Default"
                     class="absolute inset-0 w-32 h-32 rounded-full object-cover border-4 border-gray-300 shadow-md z-10"
                     style="top: 50%; left: 50%; transform: translate(-50%, -50%);">
            @endif

            {{-- Bingkai Berdasarkan XP --}}
            <img src="{{ asset($user->frame_image) }}" alt="Bingkai XP"
                 class="absolute inset-0 w-full h-full object-contain z-20">
        </div>

        <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ $user->name }}</h2>
        <p class="text-gray-600 mb-1">Email: {{ $user->email }}</p>
        <p class="text-gray-600 mb-1">Peran: <span class="font-semibold">{{ $user->role->name ?? 'Tidak Diketahui' }}</span></p>
        <p class="text-gray-600 mb-4">Organisasi: <span class="font-semibold">{{ $user->organization->name ?? 'Solo Player' }}</span></p>

        <div class="text-center bg-blue-50 p-4 rounded-lg mb-6">
            <p class="text-lg font-semibold text-blue-800">Poin Pengalaman (XP): {{ $user->xp }}</p>
        </div>

        {{-- Badge Berdasarkan XP --}}
        <div class="mt-8">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Anda adalah seorang:</h3>

            @php
                $xp = $user->xp;
                $badge = null;

                if ($xp >= 6 && $xp <= 30) {
                    $badge = 'Beginner';
                } elseif ($xp >= 31 && $xp <= 74) {
                    $badge = 'Intermediate';
                } elseif ($xp >= 75 && $xp <= 99) {
                    $badge = 'Expert';
                } elseif ($xp >= 100) {
                    $badge = 'Legendary';
                }
            @endphp

            @if($badge)
                <div class="flex flex-col items-center">
                    <p class="font-semibold text-purple-700 text-lg">{{ $badge }}</p>
                </div>
            @else
                <p class="text-gray-600">Newbie. Lakukan lebih banyak misi!</p>
            @endif
        </div>

        <div class="mt-8">
            <a href="{{ route('user.edit_profile') }}"
               class="inline-block px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 transition duration-300">
                Edit Profil
            </a>
        </div>

    </div>
</div>
@endsection
