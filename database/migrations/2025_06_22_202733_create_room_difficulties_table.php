<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi untuk membuat tabel 'room_difficulties'.
     */
    public function up(): void
    {
        Schema::create('room_difficulties', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Contoh: Beginner, Intermediate, Expert, Legendary
            $table->integer('xp_reward')->default(0); // Poin XP yang didapat jika berhasil
            $table->string('badge_name')->nullable(); // Nama badge yang diberikan
            $table->timestamps();
        });
    }

    /**
     * Batalkan migrasi (hapus tabel 'room_difficulties').
     */
    public function down(): void
    {
        Schema::dropIfExists('room_difficulties');
    }
};