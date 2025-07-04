<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi untuk membuat tabel 'booking_statuses'.
     */
    public function up(): void
    {
        Schema::create('booking_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Contoh: Pending TU, Sukses, Ditolak, dll.
            $table->timestamps();
        });
    }

    /**
     * Batalkan migrasi (hapus tabel 'booking_statuses').
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_statuses');
    }
};