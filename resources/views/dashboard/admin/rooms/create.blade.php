@extends('layouts.admin')

@section('content')
    <a href="{{ route('dashboard.rooms.index') }}" class="inline-block text-blue-600 hover:underline mb-6">&larr; Kembali ke Manajemen Ruangan</a>

    <h1 class="text-3xl font-bold mb-6 text-center">Tambah Ruangan Baru</h1>

    <div class="bg-white rounded-lg shadow-lg p-8 border border-gray-200">
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Ada Kesalahan!</strong>
                <ul class="mt-2 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('dashboard.rooms.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nama Ruangan:</label>
                <input type="text" id="name" name="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror" value="{{ old('name') }}" required>
                @error('name')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="location" class="block text-gray-700 text-sm font-bold mb-2">Lokasi (Opsional):</label>
                <input type="text" id="location" name="location" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('location') border-red-500 @enderror" value="{{ old('location') }}">
                @error('location')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Deskripsi (Opsional):</label>
                <textarea id="description" name="description" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="capacity" class="block text-gray-700 text-sm font-bold mb-2">Kapasitas:</label>
                <input type="number" id="capacity" name="capacity" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('capacity') border-red-500 @enderror" value="{{ old('capacity', 0) }}" required>
                @error('capacity')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="difficulty_id" class="block text-gray-700 text-sm font-bold mb-2">Tingkat Kesulitan:</label>
                <select id="difficulty_id" name="difficulty_id" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('difficulty_id') border-red-500 @enderror" required>
                    <option value="">Pilih Kesulitan</option>
                    @foreach($difficulties as $difficulty)
                        <option value="{{ $difficulty->id }}" {{ old('difficulty_id') == $difficulty->id ? 'selected' : '' }}>
                            {{ $difficulty->name }} (XP: {{ $difficulty->xp_reward }})
                        </option>
                    @endforeach
                </select>
                @error('difficulty_id')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Gambar Ruangan (Opsional):</label>
                <input type="file" id="image" name="image" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('image') border-red-500 @enderror">
                <p class="text-xs text-gray-500 mt-1">Ukuran maksimal 2MB, format JPEG, PNG, JPG, GIF, SVG.</p>
                @error('image')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end mt-6">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Tambahkan Ruangan
                </button>
            </div>
        </form>
    </div>
@endsection