@extends('layouts.admin') {{-- INI SUDAH DIUBAH DARI 'layouts.app' MENJADI 'layouts.admin' --}}

@section('content')
    <div class="container mx-auto px-4 py-8">
        <a href="{{ route('dashboard.bookings.index') }}" class="inline-block text-blue-600 hover:underline mb-6">&larr; Kembali ke Daftar Peminjaman</a>

        <h1 class="text-3xl font-bold mb-6 text-center">Detail Peminjaman & Persetujuan</h1>

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

        <div class="bg-white rounded-lg shadow-lg p-8 grid grid-cols-1 md:grid-cols-2 gap-8 border border-gray-200">
            <div>
                <h2 class="text-xl font-bold text-gray-800 mb-4">Informasi Peminjaman</h2>
                <p class="mb-2 text-gray-700"><strong>Peminjam:</strong> {{ $booking->user->name }} ({{ $booking->user->role->name ?? 'N/A' }})</p>
                <p class="mb-2 text-gray-700"><strong>Email Peminjam:</strong> {{ $booking->user->email }}</p>
                <p class="mb-2 text-gray-700"><strong>Organisasi:</strong> {{ $booking->user->organization->name ?? 'Solo Player' }}</p>
                <p class="mb-2 text-gray-700"><strong>Ruangan:</strong> {{ $booking->room->name }} ({{ $booking->room->location ?? 'Tidak ada informasi lokasi' }})</p>
                <p class="mb-2 text-gray-700"><strong>Tujuan:</strong> {{ $booking->purpose }}</p>
                <p class="mb-2 text-gray-700"><strong>Waktu Mulai:</strong> {{ \Carbon\Carbon::parse($booking->start_time)->format('d M Y H:i') }}</p>
                <p class="mb-2 text-gray-700"><strong>Waktu Selesai:</strong> {{ \Carbon\Carbon::parse($booking->end_time)->format('d M Y H:i') }}</p>
                <p class="mb-2 text-gray-700"><strong>Status Saat Ini:</strong> <span class="font-semibold text-blue-600">{{ $booking->status->name ?? 'Tidak Diketahui' }}</span></p>

                @if($booking->tu_approval_at)
                    <p class="mb-2 text-gray-700"><strong>Disetujui TU pada:</strong> {{ \Carbon\Carbon::parse($booking->tu_approval_at)->format('d M Y H:i') }}</p>
                @endif
                @if($booking->wadek_approval_at)
                    <p class="mb-2 text-gray-700"><strong>Disetujui Wadek pada:</strong> {{ \Carbon\Carbon::parse($booking->wadek_approval_at)->format('d M Y H:i') }}</p>
                @endif
                @if($booking->lpj_upload_at)
                    <p class="mb-2 text-gray-700"><strong>LPJ Diunggah pada:</strong> {{ \Carbon\Carbon::parse($booking->lpj_upload_at)->format('d M Y H:i') }}</p>
                @endif
                @if($booking->lpj_rejection_reason)
                    <p class="mb-2 text-red-600"><strong>Alasan Penolakan LPJ:</strong> {{ $booking->lpj_rejection_reason }}</p>
                @endif
            </div>

            <div>
                <h2 class="text-xl font-bold text-gray-800 mb-4">Dokumen Terkait</h2>
                <p class="mb-2 text-gray-700">
                    <strong>Surat Keterangan Kegiatan:</strong>
                    @if($booking->student_letter_path)
                        <a href="{{ asset('storage/' . $booking->student_letter_path) }}" target="_blank" class="text-blue-600 hover:underline">Lihat Dokumen</a>
                    @else
                        Belum diunggah.
                    @endif
                </p>

                <p class="mb-2 text-gray-700">
                    <strong>Surat Izin Peminjaman:</strong>
                    @if($booking->permission_letter_path)
                        <a href="{{ route('dashboard.bookings.download_permission_letter', $booking->id) }}" class="text-blue-600 hover:underline">Unduh Surat Izin</a>
                    @else
                        Belum tersedia.
                    @endif
                </p>

                <p class="mb-2 text-gray-700">
                    <strong>LPJ:</strong>
                    @if($booking->lpj_file_path)
                        <a href="{{ asset('storage/' . $booking->lpj_file_path) }}" target="_blank" class="text-blue-600 hover:underline">Lihat LPJ</a>
                    @else
                        LPJ belum diunggah oleh peminjam.
                    @endif
                </p>
            </div>
        </div>

        <div class="mt-8 bg-white rounded-lg shadow-lg p-8 border border-gray-200">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Aksi Persetujuan</h2>
            <div class="flex flex-wrap gap-4">
                @if ($booking->status->name === 'Pending TU')
                    <form action="{{ route('dashboard.bookings.approve_tu', $booking->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-6 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition">Setujui TU</button>
                    </form>
                    <button type="button" onclick="openRejectTuModal()" class="px-6 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition">Tolak TU</button>
                @elseif ($booking->status->name === 'Diserahkan ke Wadek' || $booking->status->name === 'Diproses Wadek')
                    <form action="{{ route('dashboard.bookings.approve_wadek', $booking->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-6 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition">Setujui Wadek</button>
                    </form>
                    <button type="button" onclick="openRejectWadekModal()" class="px-6 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition">Tolak Wadek</button>
                @elseif ($booking->status->name === 'Sukses' && !$booking->permission_letter_path) {{-- Tampilkan tombol upload jika sukses DAN surat belum diunggah --}}
                    <button type="button" onclick="openPermissionLetterUploadModal()" class="px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition">Unggah Surat Izin</button>
                @elseif ($booking->status->name === 'LPJ diperiksa')
                    <button type="button" onclick="openRejectLpjModal()" class="px-6 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition">Tolak LPJ</button>
                    <form action="{{ route('dashboard.bookings.complete_booking', $booking->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition">Selesaikan Peminjaman</button>
                    </form>
                @elseif ($booking->status->name === 'LPJ Ditolak')
                    <p class="text-red-500">Menunggu LPJ diunggah ulang oleh peminjam.</p>
                @elseif ($booking->status->name === 'Selesai')
                    <p class="text-green-600">Peminjaman ini telah selesai.</p>
                @else
                    <p class="text-gray-500">Tidak ada aksi persetujuan yang tersedia untuk status ini ({{ $booking->status->name ?? 'Tidak Diketahui' }}).</p>
                @endif
            </div>
        </div>
    </div>

    {{-- Modal untuk Tolak TU --}}
    <div id="rejectTuModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <h3 class="text-lg font-bold mb-4">Tolak Peminjaman (TU)</h3>
            <form action="{{ route('dashboard.bookings.reject_tu', $booking->id) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="rejection_reason_tu" class="block text-gray-700 text-sm font-bold mb-2">Alasan Penolakan:</label>
                    <textarea name="rejection_reason" id="rejection_reason_tu" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required></textarea>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeRejectTuModal()" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">Tolak</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal untuk Tolak Wadek --}}
    <div id="rejectWadekModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <h3 class="text-lg font-bold mb-4">Tolak Peminjaman (Wadek)</h3>
            <form action="{{ route('dashboard.bookings.reject_wadek', $booking->id) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="rejection_reason_wadek" class="block text-gray-700 text-sm font-bold mb-2">Alasan Penolakan:</label>
                    <textarea name="rejection_reason" id="rejection_reason_wadek" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required></textarea>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeRejectWadekModal()" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">Tolak</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal untuk Tolak LPJ --}}
    <div id="rejectLpjModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <h3 class="text-lg font-bold mb-4">Tolak LPJ</h3>
            <form action="{{ route('dashboard.bookings.reject_lpj', $booking->id) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="lpj_rejection_reason" class="block text-gray-700 text-sm font-bold mb-2">Alasan Penolakan LPJ:</label>
                    <textarea name="lpj_rejection_reason" id="lpj_rejection_reason" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required></textarea>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeRejectLpjModal()" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">Tolak LPJ</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal untuk Unggah Surat Izin Peminjaman (INI BARU DITAMBAHKAN) --}}
    <div id="permissionLetterUploadModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <h3 class="text-lg font-bold mb-4">Unggah Surat Izin Peminjaman</h3>
            <form action="{{ route('dashboard.bookings.upload_permission_letter', $booking->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="permission_letter_file" class="block text-gray-700 text-sm font-bold mb-2">Pilih File Surat Izin (PDF):</label>
                    <input type="file" name="permission_letter_file" id="permission_letter_file" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" accept=".pdf" required>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closePermissionLetterUploadModal()" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Unggah Surat</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openRejectTuModal() {
            document.getElementById('rejectTuModal').classList.remove('hidden');
        }
        function closeRejectTuModal() {
            document.getElementById('rejectTuModal').classList.add('hidden');
        }
        function openRejectWadekModal() {
            document.getElementById('rejectWadekModal').classList.remove('hidden');
        }
        function closeRejectWadekModal() {
            document.getElementById('rejectWadekModal').classList.add('hidden');
        }
        function openRejectLpjModal() {
            document.getElementById('rejectLpjModal').classList.remove('hidden');
        }
        function closeRejectLpjModal() {
            document.getElementById('rejectLpjModal').classList.add('hidden');
        }
        // Fungsi baru untuk modal unggah surat izin
        function openPermissionLetterUploadModal() {
            document.getElementById('permissionLetterUploadModal').classList.remove('hidden');
        }
        function closePermissionLetterUploadModal() {
            document.getElementById('permissionLetterUploadModal').classList.add('hidden');
        }
    </script>
@endsection
