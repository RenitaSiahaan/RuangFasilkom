@extends('layouts.app')

@section('content')
{{-- Main container with a single Alpine.js x-data for all modals --}}
<div x-data="{ showInfoCenterModal: false, showBookingDetailModal: false, selectedBookings: [], selectedDate: '' }" class="relative z-0">

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


    {{-- Tombol Aksi - Adopted from friend's style --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <a href="{{ route('rooms.index') }}" class="bg-gradient-to-br from-blue-500 to-indigo-600 text-white font-bold py-4 px-6 rounded-xl shadow-md hover:scale-105 transition transform duration-200 text-xl text-center">
            ⚔️ Start Quest
        </a>
        <button @click="showInfoCenterModal = true"
            class="bg-gradient-to-br from-purple-500 to-pink-500 text-white font-bold py-4 px-6 rounded-xl shadow-md hover:scale-105 transition transform duration-200 text-xl">
            📖 Info Center
        </button>
        <a href="#board-mission-section" class="bg-gradient-to-br from-green-500 to-emerald-600 text-white font-bold py-4 px-6 rounded-xl shadow-md hover:scale-105 transition transform duration-200 text-xl text-center">
            📅 Board Mission
        </a>
    </div>

    {{-- Board Mission Section (Kalender Peminjaman) - Adopted from friend's style --}}
    <div id="board-mission-section" class="bg-white border border-gray-200 rounded-lg shadow-lg p-6">
        <h2 class="text-3xl font-extrabold text-center text-indigo-700 mb-6">📜 Board Mission (Kalender Peminjaman)</h2>

        <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
            {{-- Kalender --}}
            <div class="lg:col-span-4 bg-gradient-to-br from-white via-slate-50 to-gray-100 p-4 rounded-xl shadow-inner border">
                <div class="flex justify-between items-center mb-4">
                    @php
                        $prevMonth = $currentMonth->copy()->subMonth();
                        $nextMonth = $currentMonth->copy()->addMonth();
                    @endphp
                    <a href="{{ route('home', ['month' => $prevMonth->month, 'year' => $prevMonth->year]) }}"
                       class="px-3 py-1 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400">&lt; Prev</a>
                    <h3 class="text-xl font-bold text-gray-800">{{ $currentMonth->format('F Y') }}</h3>
                    <a href="{{ route('home', ['month' => $nextMonth->month, 'year' => $nextMonth->year]) }}"
                       class="px-3 py-1 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400">Next &gt;</a>
                </div>

                <div class="grid grid-cols-7 text-center font-bold text-gray-600 mb-2">
                    <span>Sun</span><span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span>
                </div>
                <div class="grid grid-cols-7 gap-1 text-sm text-center">
                    @php
                        $daysInMonth = $currentMonth->daysInMonth;
                        $firstDayOfWeek = $currentMonth->dayOfWeek; // 0 for Sunday, 1 for Monday, etc.
                        for ($i = 0; $i < $firstDayOfWeek; $i++) {
                            echo '<div></div>';
                        }
                        for ($day = 1; $day <= $daysInMonth; $day++) {
                            $date = $currentMonth->copy()->day($day);
                            $dayKey = $date->format('Y-m-d');
                            $isToday = $date->isSameDay(\Carbon\Carbon::now());
                            $hasBookings = isset($approvedBookings[$dayKey]) && count($approvedBookings[$dayKey]) > 0;
                            // Ensure the data passed to Alpine.js matches the expected structure for split()
                            $bookingsForThisDay = json_encode($approvedBookings[$dayKey] ?? []);
                    @endphp
                        <button @click="selectedBookings = {{ $bookingsForThisDay }}; selectedDate = '{{ $date->format('d F Y') }}'; showBookingDetailModal = true"
                                class="min-h-[80px] border rounded-md px-1 py-1 relative {{ $isToday ? 'bg-blue-100 border-blue-400' : 'bg-white border-gray-300' }} {{ $hasBookings ? 'hover:bg-blue-50 cursor-pointer' : 'cursor-default' }}">
                            <span class="font-semibold">{{ $day }}</span>
                            @if($hasBookings)
                                <div class="mt-1 absolute bottom-1 left-0 right-0 px-1 text-xs space-y-0.5">
                                    @foreach($approvedBookings[$dayKey] as $booking)
                                        {{-- Title for full details on hover --}}
                                        <p class="bg-green-200 text-green-800 rounded px-1 py-0.5 truncate text-center" title="{{ $booking['room'] }} ({{ $booking['start_date'] }} - {{ $booking['end_date'] }}) - {{ $booking['borrower'] }}: {{ $booking['purpose'] }}">
                                            {{ $booking['room'] }}
                                        </p>
                                    @endforeach
                                </div>
                            @endif
                        </button>
                    @php }
                        $lastDayOfWeek = $currentMonth->copy()->endOfMonth()->dayOfWeek;
                        for ($i = $lastDayOfWeek + 1; $i <= 6; $i++) {
                            echo '<div></div>';
                        }
                    @endphp
                </div>
            </div>

            {{-- Ringkasan Hari Ini -- Adopted from friend's style --}}
            <div class="lg:col-span-1 bg-yellow-100 p-4 rounded-xl border border-yellow-300 shadow-md text-sm">
                <h3 class="font-bold text-lg mb-2 text-yellow-900 text-center">🎯 Misi Aktif Hari Ini</h3>
                @php
                    $todayKey = \Carbon\Carbon::now()->format('Y-m-d');
                    $todayBookings = $approvedBookings[$todayKey] ?? [];
                @endphp
                @if (count($todayBookings) > 0)
                    <ul class="space-y-2">
                        @foreach($todayBookings as $booking)
                            <li class="bg-white p-2 rounded shadow-sm border border-yellow-200">
                                <span class="font-semibold">{{ $booking['room'] }}</span><br>
                                <span class="text-xs text-gray-700">{{ $booking['borrower'] }} ({{ $booking['time'] }})</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-600 text-center">Tidak ada peminjaman hari ini.</p>
                @endif
            </div>
        </div>
    </div>

    {{-- Modal Detail Peminjaman - Adopted from friend's style --}}
    <div x-show="showBookingDetailModal" class="fixed inset-0 bg-black bg-opacity-60 z-40"></div>
    <div x-show="showBookingDetailModal" x-transition
         class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div @click.away="showBookingDetailModal = false"
             class="bg-white rounded-xl shadow-xl w-full max-w-xl p-6 relative">
            <button @click="showBookingDetailModal = false"
                    class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-xl font-bold">&times;</button>
            <h3 class="text-2xl font-bold mb-4 text-center text-blue-700">Detail Peminjaman <span x-text="selectedDate"></span></h3>
            <template x-if="selectedBookings.length > 0">
                <div class="space-y-4">
                    <template x-for="(booking, index) in selectedBookings" :key="index">
                        <div class="border border-gray-200 p-4 rounded-md bg-white">
                            <p class="text-lg font-semibold" x-text="booking.room"></p>
                            <p><strong>Peminjam:</strong> <span x-text="booking.borrower"></span></p>

                            {{-- Adjusted time and date parsing for consistency --}}
                            <p><strong>Waktu:</strong>
                                <span x-text="booking.start_time_formatted"></span> -
                                <span x-text="booking.end_time_formatted"></span>
                            </p>
                            <p><strong>Tujuan:</strong> <span x-text="booking.purpose"></span></p>
                            <p><strong>Tanggal:</strong>
                                <span x-text="booking.start_date_formatted"></span> -
                                <span x-text="booking.end_date_formatted"></span>
                            </p>

                            <template x-if="booking.notes">
                                <p><strong>Catatan:</strong> <span x-text="booking.notes"></span></p>
                            </template>
                        </div>
                    </template>
                </div>
            </template>
            <template x-else>
                <p class="text-gray-600">Tidak ada peminjaman untuk tanggal ini.</p>
            </template>
        </div>
    </div>

    {{-- Modal Info Center - Adopted from friend's style --}}
    <div x-show="showInfoCenterModal" class="fixed inset-0 bg-black bg-opacity-60 z-40"></div>
    <div x-show="showInfoCenterModal" x-transition
         class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div @click.away="showInfoCenterModal = false"
             class="bg-white rounded-xl shadow-2xl max-w-2xl w-full p-6 relative">
            <button @click="showInfoCenterModal = false"
                    class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-xl font-bold">&times;</button>
            <h2 class="text-2xl font-bold mb-4 text-center text-blue-800">🧠 Info Center</h2>
            <p class="mb-4 text-gray-700 text-sm">Panduan singkat tentang cara meminjam ruangan:</p>
            <ul class="list-decimal pl-5 text-sm space-y-2 text-gray-800">
                <li>Buka halaman <strong>Ruangan (Dungeon)</strong> untuk melihat dungeon yang tersedia.</li>
                <li>Pilih dungeon dan klik <strong>Lihat Detail</strong>.</li>
                <li>Tekan tombol <strong>Pesan Ruangan</strong> dan isi formulir peminjaman.</li>
                <li><strong>Mahasiswa wajib</strong> mengunggah surat keterangan kegiatan.</li>
                <li>Tunggu proses approval dari TU dan Wadek, dan pantau di <strong>Histori Misi</strong>.</li>
                <li>Jika disetujui, Anda akan mendapat surat izin & XP sesuai tingkat kesulitan dungeon!</li>
                <li>Setelah selesai, upload <strong>LPJ</strong> di halaman <strong>Histori Misi</strong>.</li>
            </ul>
        </div>
    </div>

</div>
@endsection
