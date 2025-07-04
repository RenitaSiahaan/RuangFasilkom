@extends('layouts.admin')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Manajemen Ruangan</h1>
        <a href="{{ route('dashboard.rooms.create') }}"
           class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition duration-300">
            + Tambahkan Ruangan Baru
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="min-w-full table-auto text-left">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-4 py-3">#</th>
                    <th class="px-4 py-3">Nama Ruangan</th>
                    <th class="px-4 py-3">Lokasi</th>
                    <th class="px-4 py-3">Kapasitas</th>
                    <th class="px-4 py-3">Deskripsi</th>
                    <th class="px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($rooms as $room)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3">{{ $room->name }}</td>
                        <td class="px-4 py-3">{{ $room->location }}</td>
                        <td class="px-4 py-3">{{ $room->capacity }}</td>
                        <td class="px-4 py-3">{{ $room->description }}</td>
                        <td class="px-4 py-3 space-x-2">
                            <a href="{{ route('dashboard.rooms.edit', $room->id) }}"
                               class="text-blue-600 hover:underline">Sunting</a>
                            <form action="{{ route('dashboard.rooms.destroy', $room->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline"
                                        onclick="return confirm('Yakin ingin menghapus ruangan ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-3 text-center text-gray-500">Tidak ada data ruangan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
