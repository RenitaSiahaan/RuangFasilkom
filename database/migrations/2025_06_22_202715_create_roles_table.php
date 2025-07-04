<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi untuk membuat tabel 'roles'.
     */
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Contoh: Admin, Dosen, Mahasiswa
            $table->timestamps();
        });
    }

    /**
     * Batalkan migrasi (hapus tabel 'roles').
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};