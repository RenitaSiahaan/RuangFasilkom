<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema; // Penting: Pastikan ini diimpor!

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('room_bookings', function (Blueprint $table) {
            // Menambahkan kolom lpj_file_path jika belum ada di tabel 'room_bookings'
            if (!Schema::hasColumn('room_bookings', 'lpj_file_path')) {
                $table->string('lpj_file_path')->nullable()->after('end_time');
            }

            // Menambahkan kolom lpj_upload_at jika belum ada di tabel 'room_bookings'
            if (!Schema::hasColumn('room_bookings', 'lpj_upload_at')) {
                $table->timestamp('lpj_upload_at')->nullable()->after('lpj_file_path');
            }

            // Menambahkan kolom permission_letter_path jika belum ada di tabel 'room_bookings'
            // Ini adalah kolom yang sebelumnya menyebabkan error "Column already exists" Anda.
            if (!Schema::hasColumn('room_bookings', 'permission_letter_path')) {
                $table->string('permission_letter_path')->nullable()->after('wadek_approval_at');
            }

            // Menambahkan kolom lpj_rejection_reason jika belum ada di tabel 'room_bookings'
            if (!Schema::hasColumn('room_bookings', 'lpj_rejection_reason')) {
                $table->text('lpj_rejection_reason')->nullable()->after('lpj_upload_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('room_bookings', function (Blueprint $table) {
            // Menghapus kolom lpj_file_path hanya jika kolom tersebut ada
            if (Schema::hasColumn('room_bookings', 'lpj_file_path')) {
                $table->dropColumn('lpj_file_path');
            }
            // Menghapus kolom lpj_upload_at hanya jika kolom tersebut ada
            if (Schema::hasColumn('room_bookings', 'lpj_upload_at')) {
                $table->dropColumn('lpj_upload_at');
            }
            // Menghapus kolom permission_letter_path hanya jika kolom tersebut ada
            if (Schema::hasColumn('room_bookings', 'permission_letter_path')) {
                $table->dropColumn('permission_letter_path');
            }
            // Menghapus kolom lpj_rejection_reason hanya jika kolom tersebut ada
            if (Schema::hasColumn('room_bookings', 'lpj_rejection_reason')) {
                $table->dropColumn('lpj_rejection_reason');
            }
        });
    }
};