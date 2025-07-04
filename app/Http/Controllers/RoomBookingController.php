<?php

namespace App\Http\Controllers;

use App\Models\RoomBooking;
use App\Models\Room;
use App\Models\BookingStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class RoomBookingController extends Controller
{
    public function create(Room $room)
    {
        $user = Auth::user();
        $isStudent = ($user->role_id == 3);

        return view('user.bookings.create', [
            'title' => 'Pesan Ruangan: ' . $room->name,
            'room' => $room,
            'isStudent' => $isStudent,
        ]);
    }

    public function store(Request $request, Room $room)
    {
        $user = Auth::user();
        $isStudent = ($user->role_id == 3);

        $rules = [
            'start_time' => 'required|date|after_or_equal:now',
            'end_time' => 'required|date|after:start_time',
            'purpose' => 'required|string|max:255',
        ];

        if ($isStudent) {
            $rules['student_letter'] = 'required|file|mimes:pdf,doc,docx|max:2048';
        }

        $validatedData = $request->validate($rules);

        $conflict = RoomBooking::where('room_id', $room->id)
            ->whereHas('status', fn($q) => $q->where('name', 'Sukses'))
            ->where(function ($q) use ($validatedData) {
                $start = Carbon::parse($validatedData['start_time']);
                $end = Carbon::parse($validatedData['end_time']);
                $q->whereBetween('start_time', [$start, $end])
                    ->orWhereBetween('end_time', [$start, $end])
                    ->orWhere(function ($query) use ($start, $end) {
                        $query->where('start_time', '<=', $start)
                              ->where('end_time', '>=', $end);
                    });
            })->exists();

        if ($conflict) {
            return back()->with('error', 'Ruangan sudah dipesan pada waktu tersebut. Pilih waktu lain.');
        }

        $studentLetterPath = null;
        if ($isStudent && $request->hasFile('student_letter')) {
            $studentLetterPath = $request->file('student_letter')->store('student_letters', 'public');
        }

        $pendingStatus = BookingStatus::where('name', 'Pending TU')->first();
        if (!$pendingStatus) {
            return back()->with('error', 'Status "Pending TU" tidak ditemukan. Hubungi admin.');
        }

        RoomBooking::create([
            'user_id' => $user->id,
            'room_id' => $room->id,
            'start_time' => Carbon::parse($validatedData['start_time']),
            'end_time' => Carbon::parse($validatedData['end_time']),
            'purpose' => $validatedData['purpose'],
            'is_for_student' => $isStudent,
            'student_letter_path' => $studentLetterPath,
            'status_id' => $pendingStatus->id,
        ]);

        return redirect()->route('history.index')->with('success', 'Permintaan peminjaman berhasil diajukan!');
    }

    public function uploadLpj(Request $request, RoomBooking $roomBooking)
    {
        if ($roomBooking->user_id !== Auth::id()) {
            abort(403, 'Anda tidak diizinkan mengakses ini.');
        }

        $request->validate([
            'lpj_file' => 'required|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $allowedStatuses = ['Sukses', 'LPJ Ditolak'];
        if (!in_array($roomBooking->status->name, $allowedStatuses)) {
            return back()->with('error', 'Peminjaman tidak dalam status untuk mengunggah LPJ.');
        }

        if ($request->hasFile('lpj_file')) {
            if ($roomBooking->lpj_file_path && Storage::disk('public')->exists($roomBooking->lpj_file_path)) {
                Storage::disk('public')->delete($roomBooking->lpj_file_path);
            }

            $lpjPath = $request->file('lpj_file')->store('lpj_files', 'public');
            $roomBooking->lpj_file_path = $lpjPath;
            $roomBooking->lpj_upload_at = Carbon::now();

            $newStatus = BookingStatus::where('name', 'LPJ diperiksa')->first();
            if (!$newStatus) {
                return back()->with('error', 'Status "LPJ diperiksa" tidak ditemukan.');
            }

            $roomBooking->status_id = $newStatus->id;
            $roomBooking->lpj_rejection_reason = null;
            $roomBooking->save();

            return back()->with('success', 'LPJ berhasil diunggah. Menunggu verifikasi admin.');
        }

        return back()->with('error', 'Gagal mengunggah LPJ.');
    }

    public function downloadPermissionLetter(RoomBooking $roomBooking)
    {
        if ($roomBooking->user_id !== Auth::id()) {
            abort(403, 'Anda tidak diizinkan mengakses file ini.');
        }

        if ($roomBooking->permission_letter_path && Storage::disk('public')->exists($roomBooking->permission_letter_path)) {
            return Storage::disk('public')->download($roomBooking->permission_letter_path);
        }

        return back()->with('error', 'Surat izin tidak ditemukan.');
    }

    /**
     * ✅ Fitur baru: Membatalkan peminjaman oleh user (dengan alasan)
     */
    public function cancel(Request $request, RoomBooking $roomBooking)
    {
        if ($roomBooking->user_id !== Auth::id()) {
            abort(403, 'Anda tidak diizinkan membatalkan ini.');
        }

        // Hanya boleh batalkan jika H-3 sebelum mulai
       $limitDate = $roomBooking->start_time->copy()->subDays(3);
if (now()->gt($limitDate)) {
    return back()->with('error', 'Peminjaman hanya bisa dibatalkan maksimal 3 hari sebelum waktu mulai.');
}
        $request->validate([
            'cancellation_reason' => 'required|string|max:255',
        ]);

        $cancelStatus = BookingStatus::where('name', 'Dibatalkan')->first();
        if (!$cancelStatus) {
            return back()->with('error', 'Status "Dibatalkan" tidak ditemukan.');
        }

        $roomBooking->status_id = $cancelStatus->id;
        $roomBooking->cancellation_reason = $request->cancellation_reason;
        $roomBooking->save();

        return redirect()->route('history.index')->with('success', 'Peminjaman berhasil dibatalkan.');
    }
}
