<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomBookingController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Dashboard\AdminController;
use App\Http\Controllers\Dashboard\ManageUsersController;
use App\Http\Controllers\Dashboard\ManageRoomsController;
use App\Http\Controllers\Dashboard\ManageBookingsController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;

// =====================
// AUTH: FORGOT & RESET PASSWORD
// =====================
Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
    ->middleware('guest')
    ->name('password.request');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
    ->middleware('guest')
    ->name('password.email');

Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
    ->middleware('guest')
    ->name('password.reset');

Route::post('/reset-password', [NewPasswordController::class, 'store'])
    ->middleware('guest')
    ->name('password.update');

// =====================
// REDIRECT DEFAULT
// =====================
Route::get('/', function () {
    return redirect('/login');
});

// =====================
// LOGIN & LOGOUT
// =====================
Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// =====================
// ROUTE PENGGUNA (MAHASISWA & DOSEN)
// =====================
Route::middleware(['auth', 'prevent_admin'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Rooms
    Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
    Route::get('/rooms/{room}', [RoomController::class, 'show'])->name('rooms.show');
    Route::get('/rooms/{room}/book', [RoomBookingController::class, 'create'])->name('room_bookings.create');
    Route::post('/rooms/{room}/book', [RoomBookingController::class, 'store'])->name('room_bookings.store');

    // History
    Route::get('/history', [HistoryController::class, 'index'])->name('history.index');
    Route::post('/history/{roomBooking}/upload-lpj', [RoomBookingController::class, 'uploadLpj'])->name('history.upload_lpj');
    Route::post('/history/{roomBooking}/cancel', [RoomBookingController::class, 'cancel'])->name('history.cancel');


    // File Download (Surat Pengantar, LPJ, Surat Izin)
    Route::get('/history/{roomBooking}/download-student-letter', [RoomBookingController::class, 'downloadStudentLetter'])->name('bookings.download-student-letter');
    Route::get('/history/{roomBooking}/download-lpj', [RoomBookingController::class, 'downloadLpj'])->name('bookings.download-lpj');
    Route::get('/history/{roomBooking}/download-permission-letter', [RoomBookingController::class, 'downloadPermissionLetter'])->name('bookings.download-permission-letter');

    // Profile
    Route::get('/user', [ProfileController::class, 'show'])->name('user.profile');
    Route::get('/user/edit', [ProfileController::class, 'edit'])->name('user.edit_profile');
    Route::post('/user/update', [ProfileController::class, 'update'])->name('user.update_profile');
});

// =====================
// ROUTE ADMIN DASHBOARD
// =====================
Route::prefix('dashboard')
    ->name('dashboard.')
    ->middleware(['auth', 'can:access-admin-dashboard'])
    ->group(function () {
        // Dashboard Home
        Route::get('/', [AdminController::class, 'index'])->name('index');

        // User Management
        Route::resource('users', ManageUsersController::class)->except(['show']);

        // Room Management
        Route::resource('rooms', ManageRoomsController::class);

        // Booking Management
        Route::get('bookings', [ManageBookingsController::class, 'index'])->name('bookings.index');
        Route::get('bookings/{roomBooking}', [ManageBookingsController::class, 'show'])->name('bookings.show');

        // Persetujuan TU dan Wadek
        Route::post('bookings/{roomBooking}/approve-tu', [ManageBookingsController::class, 'approveTu'])->name('bookings.approve_tu');
        Route::post('bookings/{roomBooking}/reject-tu', [ManageBookingsController::class, 'rejectTu'])->name('bookings.reject_tu');
        Route::post('bookings/{roomBooking}/approve-wadek', [ManageBookingsController::class, 'approveWadek'])->name('bookings.approve_wadek');
        Route::post('bookings/{roomBooking}/reject-wadek', [ManageBookingsController::class, 'rejectWadek'])->name('bookings.reject_wadek');

        // LPJ
        Route::post('bookings/{roomBooking}/reject-lpj', [ManageBookingsController::class, 'rejectLpj'])->name('bookings.reject_lpj');
        Route::post('bookings/{roomBooking}/complete', [ManageBookingsController::class, 'completeBooking'])->name('bookings.complete_booking');

        // Surat Izin
        Route::get('bookings/{roomBooking}/download-permission-letter', [ManageBookingsController::class, 'downloadPermissionLetter'])->name('bookings.download_permission_letter');
        Route::post('bookings/{roomBooking}/upload-permission-letter', [ManageBookingsController::class, 'uploadPermissionLetter'])->name('bookings.upload_permission_letter');
    });
