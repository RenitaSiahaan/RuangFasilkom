<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi untuk membuat tabel 'rooms'.
     */
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('location')->nullable(); // Contoh: Gedung FIK 1 Lantai 2
            $table->text('description')->nullable();
            $table->integer('capacity')->default(0);
            // Kunci asing ke tabel 'room_difficulties'
            $table->foreignId('difficulty_id')->constrained('room_difficulties')->onDelete('cascade');
            $table->string('image')->nullable(); // Path gambar ruangan
            $table->timestamps();
        });
    }

    /**
     * Batalkan migrasi (hapus tabel 'rooms').
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};