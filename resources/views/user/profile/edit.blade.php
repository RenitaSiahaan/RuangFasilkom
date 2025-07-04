@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <a href="{{ route('user.profile') }}" class="text-blue-600 hover:underline mb-6 inline-block">&larr; Kembali ke Profil</a>

    <h1 class="text-3xl font-bold mb-6 text-center">Edit Profil Petualang</h1>

    <div class="bg-white rounded-lg shadow-lg p-8 border border-gray-200">
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <strong class="font-bold">Ada Kesalahan:</strong>
                <ul class="mt-2 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('user.update_profile') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Avatar --}}
            <div class="mb-4 text-center">
                <label class="block text-gray-700 font-bold mb-2">Avatar:</label>
                <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('images/default_avatar.png') }}"
                     alt="Avatar" class="w-24 h-24 rounded-full mx-auto object-cover border-2 border-gray-300 mb-2">
                <input type="file" name="avatar" class="mt-2 text-sm text-gray-600">
                @error('avatar')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            {{-- Nama --}}
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-bold mb-2">Nama:</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring @error('name') border-red-500 @enderror" required>
                @error('name')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-bold mb-2">Email:</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring @error('email') border-red-500 @enderror" required>
                @error('email')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            {{-- Organisasi --}}
            <div class="mb-4">
                <label for="organization_id" class="block text-gray-700 font-bold mb-2">Organisasi:</label>
                <select name="organization_id" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring">
                    <option value="">Pilih Organisasi (Opsional)</option>
                    @foreach ($organizations as $org)
                        <option value="{{ $org->id }}" {{ old('organization_id', $user->organization_id) == $org->id ? 'selected' : '' }}>
                            {{ $org->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Password Baru --}}
            <div class="mb-4">
                <label for="password" class="block text-gray-700 font-bold mb-2">Kata Sandi Baru (opsional):</label>
                <input type="password" name="password"
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring @error('password') border-red-500 @enderror">
                @error('password')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            {{-- Konfirmasi Password --}}
            <div class="mb-6">
                <label for="password_confirmation" class="block text-gray-700 font-bold mb-2">Konfirmasi Kata Sandi Baru:</label>
                <input type="password" name="password_confirmation"
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring">
            </div>

            <div class="text-right">
                <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700">Perbarui</button>
            </div>
        </form>
    </div>
</div>
@endsection
