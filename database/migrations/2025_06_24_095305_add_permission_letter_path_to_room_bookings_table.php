<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::table('room_bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('room_bookings', 'permission_letter_path')) {
                $table->string('permission_letter_path')->nullable()->after('wadek_approval_at');
            }

            if (!Schema::hasColumn('room_bookings', 'lpj_rejection_reason')) {
                $table->text('lpj_rejection_reason')->nullable()->after('lpj_upload_at');
            }
        });
    }

    /**
     * Balikkan migrasi.
     */
    public function down(): void
    {
        Schema::table('room_bookings', function (Blueprint $table) {
            if (Schema::hasColumn('room_bookings', 'permission_letter_path')) {
                $table->dropColumn('permission_letter_path');
            }

            if (Schema::hasColumn('room_bookings', 'lpj_rejection_reason')) {
                $table->dropColumn('lpj_rejection_reason');
            }
        });
    }
};
