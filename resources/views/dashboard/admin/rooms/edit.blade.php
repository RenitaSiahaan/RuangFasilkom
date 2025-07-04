@extends('layouts.admin')

@section('content')
    <a href="{{ route('dashboard.rooms.index') }}" class="inline-block text-blue-600 hover:underline mb-6">&larr; Kembali ke Manajemen Ruangan</a>

    <h1 class="text-3xl font-bold mb-6 text-center">Edit Ruangan: {{ $room->name }}</h1>

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

        <form action="{{ route('dashboard.rooms.update', $room->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') {{-- Gunakan method PUT untuk update --}}

            <div class="mb-4 text-center">
                <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Gambar Ruangan:</label>
                @if($room->image)
                    <img src="{{ asset($room->image) }}" alt="Gambar Ruangan Saat Ini" class="w-48 h-auto mx-auto object-cover border-2 border-gray-300 mb-2">
                @else
                    <img src="{{ asset('images/default_room.png') }}" alt="Gambar Default Ruangan" class="w-48 h-auto mx-auto object-cover border-2 border-gray-300 mb-2">
                @endif
                <input type="file" id="image" name="image" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 mt-2">
                @error('image')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nama Ruangan:</label>
                <input type="text" id="name" name="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror" value="{{ old('name', $room->name) }}" required>
                @error('name')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="location" class="block text-gray-700 text-sm font-bold mb-2">Lokasi (Opsional):</label>
                <input type="text" id="location" name="location" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('location') border-red-500 @enderror" value="{{ old('location', $room->location) }}">
                @error('location')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Deskripsi (Opsional):</label>
                <textarea id="description" name="description" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('description') border-red-500 @enderror">{{ old('description', $room->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="capacity" class="block text-gray-700 text-sm font-bold mb-2">Kapasitas:</label>
                <input type="number" id="capacity" name="capacity" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('capacity') border-red-500 @enderror" value="{{ old('capacity', $room->capacity) }}" required>
                @error('capacity')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="difficulty_id" class="block text-gray-700 text-sm font-bold mb-2">Tingkat Kesulitan:</label>
                <select id="difficulty_id" name="difficulty_id" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('difficulty_id') border-red-500 @enderror" required>
                    <option value="">Pilih Kesulitan</option>
                    @foreach($difficulties as $difficulty)
                        <option value="{{ $difficulty->id }}" {{ old('difficulty_id', $room->difficulty_id) == $difficulty->id ? 'selected' : '' }}>
                            {{ $difficulty->name }} (XP: {{ $difficulty->xp_reward }})
                        </option>
                    @endforeach
                </select>
                @error('difficulty_id')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end mt-6">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Perbarui Ruangan
                </button>
            </div>
        </form>
    </div>
@endsection