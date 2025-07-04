<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi untuk membuat tabel 'room_bookings'.
     */
    public function up(): void
    {
        Schema::create('room_bookings', function (Blueprint $table) {
            $table->id();
            // Kunci asing ke tabel 'users'
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            // Kunci asing ke tabel 'rooms'
            $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade');
            $table->dateTime('start_time'); // Waktu mulai peminjaman
            $table->dateTime('end_time');   // Waktu selesai peminjaman
            $table->string('purpose');      // Tujuan peminjaman

            // Kolom khusus untuk peminjaman mahasiswa
            $table->boolean('is_for_student')->default(false); // true jika peminjam adalah mahasiswa
            $table->string('student_letter_path')->nullable(); // Path file surat keterangan mahasiswa

            // Kunci asing ke tabel 'booking_statuses'
            $table->foreignId('status_id')->constrained('booking_statuses');
            $table->text('rejection_reason')->nullable(); // Alasan penolakan oleh admin/TU/Wadek

            $table->dateTime('tu_approval_at')->nullable(); // Waktu persetujuan oleh TU
            $table->dateTime('wadek_approval_at')->nullable(); // Waktu persetujuan oleh Wadek

            $table->string('permission_letter_path')->nullable(); // Path surat izin yang bisa diunduh user
            $table->string('lpj_path')->nullable(); // Path laporan pertanggungjawaban (LPJ)

            $table->timestamps();
        });
    }

    /**
     * Batalkan migrasi (hapus tabel 'room_bookings').
     */
    public function down(): void
    {
        Schema::dropIfExists('room_bookings');
    }
};