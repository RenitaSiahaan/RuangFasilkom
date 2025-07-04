<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\RoomBooking;
use App\Models\BookingStatus;
use App\Models\Badge;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate; // Diperlukan untuk debugging, bisa dihapus nanti jika tidak digunakan
use Illuminate\Validation\Rule;

class ManageBookingsController extends Controller
{
    /**
     * Menampilkan daftar semua peminjaman ruangan yang memerlukan persetujuan.
     */
    public function index()
    {
        $bookings = RoomBooking::whereHas('status', function ($query) {
                                    $query->whereNotIn('name', ['Selesai', 'Ditolak TU', 'Ditolak Wadek']);
                                })
                                ->with('user.role', 'room.difficulty', 'status')
                                ->orderBy('created_at', 'desc')
                                ->get();

        return view('dashboard.admin.bookings.index', [
            'title' => 'Manajemen Persetujuan Peminjaman',
            'bookings' => $bookings,
        ]);
    }

    /**
     * Menampilkan detail peminjaman tertentu.
     */
    public function show(RoomBooking $roomBooking)
    {
        // --- DEBUGGING (bisa dihapus setelah masalah teratasi) ---
        // Anda bisa mengkomentari atau menghapus blok ini setelah debugging selesai
        // $user = Auth::user();
        // dump('--- DEBUGGING: ManageBookingsController@show ---');
        // dump('Is User Logged In: ' . (Auth::check() ? 'TRUE' : 'FALSE'));
        // if (Auth::check()) {
        //     dump('User ID: ' . $user->id);
        //     dump('User Email: ' . $user->email);
        //     dump('User Role ID: ' . $user->role_id);
        //     dump('User Role Name: ' . ($user->role ? $user->role->name : 'N/A (Role not loaded or null)'));
        //     dump('Gate "access-admin-dashboard" allows: ' . (Gate::allows('access-admin-dashboard') ? 'TRUE' : 'FALSE'));
        // }
        // dump('Booking ID: ' . $roomBooking->id);
        // dump('Booking Status Name: ' . ($roomBooking->status ? $roomBooking->status->name : 'N/A (Status not loaded or null)'));
        // dump('Booking Permission Letter Path: ' . ($roomBooking->permission_letter_path ?? 'N/A (Null)'));
        // dump('--- END DEBUGGING ---');


        $roomBooking->load('user.role', 'user.organization', 'room.difficulty', 'status');
        return view('dashboard.admin.bookings.show', [
            'title' => 'Detail Peminjaman: ' . $roomBooking->user->name,
            'booking' => $roomBooking,
        ]);
    }


    /**
     * Menyetujui peminjaman oleh Tata Usaha (TU).
     */
    public function approveTu(Request $request, RoomBooking $roomBooking)
    {
        if (Gate::denies('access-admin-dashboard')) {
            abort(403, 'Anda tidak memiliki izin untuk melakukan tindakan ini.');
        }

        if ($roomBooking->status->name !== 'Pending TU') {
            return back()->with('error', 'Peminjaman tidak dalam status "Pending TU".');
        }

        $newStatus = BookingStatus::where('name', 'Diserahkan ke Wadek')->first();
        if (!$newStatus) {
            return back()->with('error', 'Status "Diserahkan ke Wadek" tidak ditemukan.');
        }

        $roomBooking->status_id = $newStatus->id;
        $roomBooking->tu_approval_at = Carbon::now();
        $roomBooking->save();

        return back()->with('success', 'Peminjaman berhasil disetujui oleh TU dan diteruskan ke Wadek!');
    }

    /**
     * Menolak peminjaman oleh Tata Usaha (TU).
     */
    public function rejectTu(Request $request, RoomBooking $roomBooking)
    {
        if (Gate::denies('access-admin-dashboard')) {
            abort(403, 'Anda tidak memiliki izin untuk melakukan tindakan ini.');
        }

        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        if (!in_array($roomBooking->status->name, ['Pending TU', 'Diproses TU'])) {
            return back()->with('error', 'Peminjaman tidak dapat ditolak oleh TU dalam status ini.');
        }

        $newStatus = BookingStatus::where('name', 'Ditolak TU')->first();
        if (!$newStatus) {
            return back()->with('error', 'Status "Ditolak TU" tidak ditemukan.');
        }

        $roomBooking->status_id = $newStatus->id;
        $roomBooking->rejection_reason = $request->rejection_reason;
        $roomBooking->tu_approval_at = Carbon::now();
        $roomBooking->save();

        return back()->with('success', 'Peminjaman berhasil ditolak oleh TU.');
    }

    /**
     * Menyetujui peminjaman oleh Wakil Dekan (Wadek).
     * Setelah disetujui, XP dan Badge diberikan. Surat izin akan diunggah terpisah.
     */
    public function approveWadek(Request $request, RoomBooking $roomBooking)
    {
        if (Gate::denies('access-admin-dashboard')) {
            abort(403, 'Anda tidak memiliki izin untuk melakukan tindakan ini.');
        }

        if (!in_array($roomBooking->status->name, ['Diserahkan ke Wadek', 'Diproses Wadek'])) {
            return back()->with('error', 'Peminjaman tidak dalam status untuk persetujuan Wadek.');
        }

        $newStatus = BookingStatus::where('name', 'Sukses')->first();
        if (!$newStatus) {
            return back()->with('error', 'Status "Sukses" tidak ditemukan.');
        }

        // --- Logika Pemberian XP dan Badge ---
        $user = $roomBooking->user;
        $roomDifficulty = $roomBooking->room->difficulty;

        // 1. Tambah XP
        if ($roomDifficulty && $roomDifficulty->xp_reward > 0) {
            $user->xp += $roomDifficulty->xp_reward;
            $user->save();
        }

        // 2. Berikan Badge (asumsi: RoomDifficulty punya relasi ke Badge via badge_id)
        if ($roomDifficulty && $roomDifficulty->badge) {
            $badgeToAward = $roomDifficulty->badge;
            if (!$user->badges->contains($badgeToAward->id)) {
                $user->badges()->attach($badgeToAward->id, ['earned_at' => Carbon::now()]);
            }
        }
        // --- Akhir Logika XP & Badge ---

        // Logika pembuatan surat izin Dihapus dari sini.
        // Surat izin akan diunggah secara manual oleh admin setelah persetujuan Wadek.
        // permission_letter_path akan tetap null sampai admin mengunggahnya.

        $roomBooking->status_id = $newStatus->id;
        $roomBooking->wadek_approval_at = Carbon::now();
        $roomBooking->save();

        return back()->with('success', 'Peminjaman berhasil disetujui oleh Wadek. XP dan Badge diberikan! Admin dapat mengunggah surat izin sekarang.');
    }

    /**
     * Mengunggah Surat Izin Peminjaman oleh Admin.
     */
    public function uploadPermissionLetter(Request $request, RoomBooking $roomBooking)
    {
        if (Gate::denies('access-admin-dashboard')) {
            abort(403, 'Anda tidak memiliki izin untuk melakukan tindakan ini.');
        }

        $request->validate([
            'permission_letter_file' => 'required|file|mimes:pdf|max:2048', // Hanya PDF, max 2MB
        ]);

        // Pastikan booking sudah Sukses atau LPJ Diperiksa (jika alurnya begitu)
        // Atau sesuaikan status di mana admin diperbolehkan mengunggah surat izin
        if ($roomBooking->status->name !== 'Sukses') {
            return back()->with('error', 'Surat izin hanya dapat diunggah untuk peminjaman berstatus "Sukses".');
        }

        // Hapus file lama jika ada
        if ($roomBooking->permission_letter_path && Storage::disk('public')->exists($roomBooking->permission_letter_path)) {
            Storage::disk('public')->delete($roomBooking->permission_letter_path);
        }

        // Simpan file baru
        $filePath = $request->file('permission_letter_file')->store('permission_letters', 'public');
        $roomBooking->permission_letter_path = $filePath;
        $roomBooking->save();

        return back()->with('success', 'Surat Izin Peminjaman berhasil diunggah.');
    }


    /**
     * Menolak LPJ setelah diunggah.
     */
    public function rejectLpj(Request $request, RoomBooking $roomBooking)
    {
        if (Gate::denies('access-admin-dashboard')) {
            abort(403, 'Anda tidak memiliki izin untuk melakukan tindakan ini.');
        }

        $request->validate([
            'lpj_rejection_reason' => 'required|string|max:500',
        ]);

        if ($roomBooking->status->name !== 'LPJ diperiksa') {
            return back()->with('error', 'LPJ tidak dalam status untuk ditolak.');
        }

        $newStatus = BookingStatus::where('name', 'LPJ Ditolak')->first();
        if (!$newStatus) {
            return back()->with('error', 'Status "LPJ Ditolak" tidak ditemukan.');
        }

        $roomBooking->status_id = $newStatus->id;
        $roomBooking->lpj_rejection_reason = $request->lpj_rejection_reason;
        $roomBooking->save();

        return back()->with('success', 'LPJ berhasil ditolak. Pengguna dapat mengunggah ulang.');
    }

    /**
     * Menyelesaikan peminjaman (setelah LPJ diterima atau alur selesai).
     */
    public function completeBooking(RoomBooking $roomBooking)
    {
        if (Gate::denies('access-admin-dashboard')) {
            abort(403, 'Anda tidak memiliki izin untuk melakukan tindakan ini.');
        }

        if (!in_array($roomBooking->status->name, ['Sukses', 'LPJ diperiksa'])) {
             return back()->with('error', 'Peminjaman tidak dalam status yang dapat diselesaikan.');
        }

        $newStatus = BookingStatus::where('name', 'Selesai')->first();
        if (!$newStatus) {
            return back()->with('error', 'Status "Selesai" tidak ditemukan.');
        }

        $roomBooking->status_id = $newStatus->id;
        $roomBooking->save();

        return back()->with('success', 'Peminjaman berhasil diselesaikan!');
    }

    /**
     * Mengunduh surat izin peminjaman (jika ada).
     */
    public function downloadPermissionLetter(RoomBooking $roomBooking)
    {
        if (Gate::denies('access-admin-dashboard')) {
            abort(403, 'Anda tidak memiliki izin untuk melakukan tindakan ini.');
        }

        $filePath = str_replace('storage/', '', $roomBooking->permission_letter_path);

        if ($roomBooking->permission_letter_path && Storage::disk('public')->exists($filePath)) {
            return Storage::disk('public')->download($filePath);
        }

        return back()->with('error', 'Surat izin tidak ditemukan.');
    }
}
