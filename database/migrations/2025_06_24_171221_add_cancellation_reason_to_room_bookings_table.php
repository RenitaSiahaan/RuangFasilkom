<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCancellationReasonToRoomBookingsTable extends Migration
{
    /**
     * Menambahkan kolom cancellation_reason ke tabel room_bookings
     */
    public function up(): void
    {
        Schema::table('room_bookings', function (Blueprint $table) {
            $table->text('cancellation_reason')->nullable()->after('lpj_rejection_reason');
        });
    }

    /**
     * Menghapus kolom cancellation_reason saat rollback
     */
    public function down(): void
    {
        Schema::table('room_bookings', function (Blueprint $table) {
            $table->dropColumn('cancellation_reason');
        });
    }
}
