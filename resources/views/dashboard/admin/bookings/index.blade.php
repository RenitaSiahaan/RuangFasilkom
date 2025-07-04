@extends('layouts.admin')

@section('content')
    <h1 class="text-3xl font-bold mb-6 text-center">Manajemen Persetujuan Peminjaman</h1>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <table class="min-w-full leading-normal">
            <thead>
                <tr>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Peminjam
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Ruangan
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Waktu Peminjaman
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Tujuan
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Status
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
                    <tr>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">
                                {{ $booking->user->name }} ({{ $booking->user->role->name ?? 'N/A' }})
                            </p>
                            @if($booking->is_for_student && $booking->student_letter_path)
                                <p class="text-gray-600 text-xs">
                                    <a href="{{ asset($booking->student_letter_path) }}" target="_blank" class="text-blue-500 hover:underline">Surat Mahasiswa</a>
                                </p>
                            @endif
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ $booking->room->name }}</p>
                            <p class="text-gray-600 text-xs">({{ $booking->room->difficulty->name ?? 'N/A' }} - {{ $booking->room->difficulty->xp_reward ?? 0 }} XP)</p>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ $booking->start_time->format('d M Y H:i') }}</p>
                            <p class="text-gray-600 whitespace-no-wrap">- {{ $booking->end_time->format('d M Y H:i') }}</p>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ $booking->purpose }}</p>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <span class="relative inline-block px-3 py-1 font-semibold leading-tight {{
                                $booking->status->name == 'Sukses' ? 'text-green-900' :
                                ($booking->status->name == 'Selesai/LPJ diupload' ? 'text-green-900' :
                                ($booking->status->name == 'Ditolak TU' || $booking->status->name == 'Ditolak Wadek' ? 'text-red-900' :
                                'text-yellow-900'))
                            }}">
                                <span aria-hidden="true" class="absolute inset-0 opacity-50 rounded-full {{
                                    $booking->status->name == 'Sukses' ? 'bg-green-200' :
                                    ($booking->status->name == 'Selesai/LPJ diupload' ? 'bg-green-200' :
                                    ($booking->status->name == 'Ditolak TU' || $booking->status->name == 'Ditolak Wadek' ? 'bg-red-200' :
                                    'bg-yellow-200'))
                                }}"></span>
                                <span class="relative">{{ $booking->status->name }}</span>
                            </span>
                            @if($booking->rejection_reason)
                                <p class="text-red-600 text-xs mt-1">Alasan: {{ $booking->rejection_reason }}</p>
                            @endif
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center">
                            <a href="{{ route('dashboard.bookings.show', $booking->id) }}" class="text-blue-600 hover:text-blue-900">Lihat/Proses</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center text-gray-600">
                            Belum ada peminjaman yang memerlukan persetujuan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection