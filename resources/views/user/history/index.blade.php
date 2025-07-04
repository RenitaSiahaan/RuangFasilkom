@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6 text-center">Histori Misi (Peminjaman Ruangan Anda)</h1>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                {{ session('error') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Ada Kesalahan:</strong>
                <ul class="mt-2 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if($bookings->isEmpty())
            <p class="text-center text-gray-600">Anda belum memiliki riwayat peminjaman.</p>
        @else
            <div class="grid grid-cols-1 gap-6">
                @foreach($bookings as $booking)
                    <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-800 mb-2">Ruangan: {{ $booking->room->name }}</h2>
                        <p class="text-gray-600 mb-1"><strong>Tujuan:</strong> {{ $booking->purpose }}</p>
                        <p class="text-gray-600 mb-1"><strong>Waktu:</strong> {{ \Carbon\Carbon::parse($booking->start_time)->format('d M Y H:i') }} - {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}</p>
                        <p class="text-gray-600 mb-4"><strong>Status:</strong> <span class="font-bold text-blue-600">{{ $booking->status->name ?? 'Tidak Diketahui' }}</span></p>

                        @if($booking->lpj_rejection_reason)
                            <p class="text-red-600 mb-4"><strong>Alasan Penolakan LPJ:</strong> {{ $booking->lpj_rejection_reason }}</p>
                        @endif

                        @if($booking->cancel_reason)
                            <p class="text-yellow-700 mb-4"><strong>Alasan Pembatalan:</strong> {{ $booking->cancel_reason }}</p>
                        @endif

                        <div class="mt-4 flex flex-wrap gap-3 items-center">
                            @if($booking->student_letter_path)
                                <a href="{{ asset('storage/' . $booking->student_letter_path) }}" target="_blank" class="px-4 py-2 bg-purple-500 text-white rounded-md hover:bg-purple-600 transition">
                                    Lihat Surat Keterangan
                                </a>
                            @endif

                            @if($booking->permission_letter_path)
                                <a href="{{ route('bookings.download-permission-letter', $booking->id) }}" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition">
                                    Unduh Surat Izin Peminjaman
                                </a>
                            @endif

                            @if(in_array($booking->status->name, ['Sukses', 'LPJ Ditolak']))
                                <button type="button" onclick="openLpjUploadModal({{ $booking->id }})" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition">
                                    {{ $booking->status->name === 'LPJ Ditolak' ? 'Unggah Ulang LPJ' : 'Unggah Laporan Pertanggungjawaban (LPJ)' }}
                                </button>
                            @elseif(in_array($booking->status->name, ['LPJ diperiksa']))
                                <p class="text-gray-500">LPJ Anda sedang diperiksa.</p>
                            @elseif(in_array($booking->status->name, ['Selesai']))
                                <p class="text-green-600">Peminjaman ini telah selesai.</p>
                            @endif

                            @if($booking->lpj_file_path && !in_array($booking->status->name, ['LPJ Ditolak', 'Selesai']))
                                <a href="{{ asset('storage/' . $booking->lpj_file_path) }}" target="_blank" class="px-4 py-2 bg-purple-500 text-white rounded-md hover:bg-purple-600 transition">
                                    Lihat Laporan Pertanggungjawaban (LPJ)
                                </a>
                            @endif

                            @if(\Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($booking->start_time), false) >= 3 && $booking->status->name != 'Dibatalkan')
                                <button onclick="openCancelModal({{ $booking->id }})" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 transition">
                                    Batalkan Peminjaman
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <div id="lpjUploadModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <h3 class="text-lg font-bold mb-4">Unggah LPJ</h3>
            <form id="lpjUploadForm" action="" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="lpj_file" class="block text-gray-700 text-sm font-bold mb-2">Pilih File LPJ (PDF, DOC, DOCX):</label>
                    <input type="file" name="lpj_file" id="lpj_file" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeLpjUploadModal()" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">Unggah</button>
                </div>
            </form>
        </div>
    </div>

    <div id="cancelModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="bg-white p-6 rounded shadow-md max-w-md mx-auto mt-20">
            <h3 class="text-lg font-bold mb-4">Batalkan Peminjaman</h3>
            <form id="cancelForm" method="POST" action="">
                @csrf
                <label for="cancellation_reason" class="block mb-2 text-sm">Alasan Pembatalan:</label>
                <input type="text" name="cancellation_reason" id="cancellation_reason" class="w-full border rounded p-2 mb-4" required>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeCancelModal()" class="px-4 py-2 bg-gray-300 rounded">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded">Kirim</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openLpjUploadModal(bookingId) {
            const form = document.getElementById('lpjUploadForm');
            form.action = `/history/${bookingId}/upload-lpj`;
            document.getElementById('lpjUploadModal').classList.remove('hidden');
        }

        function closeLpjUploadModal() {
            document.getElementById('lpjUploadModal').classList.add('hidden');
        }

        function openCancelModal(bookingId) {
            const form = document.getElementById('cancelForm');
            form.action = `/history/${bookingId}/cancel`;
            document.getElementById('cancelModal').classList.remove('hidden');
        }

        function closeCancelModal() {
            document.getElementById('cancelModal').classList.add('hidden');
        }
    </script>
@endsection
