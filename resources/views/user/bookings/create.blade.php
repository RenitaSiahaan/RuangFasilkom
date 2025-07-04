@extends('layouts.app')

@section('content')
    <a href="{{ route('rooms.show', $room->id) }}" class="inline-block text-blue-600 hover:underline mb-6">&larr; Kembali ke Detail Ruangan</a>

    <h1 class="text-3xl font-bold mb-6 text-center">Form Peminjaman Ruangan: {{ $room->name }}</h1>

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

        <form action="{{ route('room_bookings.store', $room->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="room_name" class="block text-gray-700 text-sm font-bold mb-2">Ruangan yang Dipinjam:</label>
                <input type="text" id="room_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 bg-gray-100 leading-tight focus:outline-none focus:shadow-outline" value="{{ $room->name }}" readonly disabled>
            </div>

            <div class="mb-4">
                <label for="start_time" class="block text-gray-700 text-sm font-bold mb-2">Waktu Mulai:</label>
                <input type="datetime-local" id="start_time" name="start_time" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('start_time') border-red-500 @enderror" value="{{ old('start_time') }}" required>
                @error('start_time')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="end_time" class="block text-gray-700 text-sm font-bold mb-2">Waktu Selesai:</label>
                <input type="datetime-local" id="end_time" name="end_time" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('end_time') border-red-500 @enderror" value="{{ old('end_time') }}" required>
                @error('end_time')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="purpose" class="block text-gray-700 text-sm font-bold mb-2">Tujuan Peminjaman:</label>
                <textarea id="purpose" name="purpose" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('purpose') border-red-500 @enderror" required>{{ old('purpose') }}</textarea>
                @error('purpose')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            @if($isStudent)
                <div class="mb-6 bg-yellow-50 border-l-4 border-yellow-500 text-yellow-700 p-4" role="alert">
                    <p class="font-bold">Perhatian Mahasiswa:</p>
                    <p>Anda wajib mengunggah surat keterangan kegiatan. Ukuran maksimal 2MB, format PDF, DOC, atau DOCX.</p>
                </div>
                <div class="mb-4">
                    <label for="student_letter" class="block text-gray-700 text-sm font-bold mb-2">Unggah Surat Keterangan Kegiatan:</label>
                    <input type="file" id="student_letter" name="student_letter" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('student_letter') border-red-500 @enderror" required>
                    @error('student_letter')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
            @endif

            <div class="flex items-center justify-end mt-6">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Ajukan Peminjaman
                </button>
            </div>
        </form>
    </div>
@endsection