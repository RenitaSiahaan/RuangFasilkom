<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi untuk membuat tabel 'organizations'.
     */
    public function up(): void
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Contoh: HIMA, BEM, Komunitas, Solo Player
            $table->timestamps();
        });
    }

    /**
     * Batalkan migrasi (hapus tabel 'organizations').
     */
    public function down(): void
    {
        Schema::dropIfExists('organizations');
    }
};