<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi untuk menambahkan kolom-kolom baru ke tabel 'users'.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Tambahkan kolom 'role_id' sebagai kunci asing ke tabel 'roles'
            // Defaultnya 3 (Mahasiswa) karena user baru biasanya Mahasiswa
            $table->foreignId('role_id')->default(3)->constrained('roles')->after('email');
            // Tambahkan kolom 'organization_id' sebagai kunci asing ke tabel 'organizations'
            // Bisa null jika pengguna adalah 'Solo Player'
            $table->foreignId('organization_id')->nullable()->constrained('organizations')->after('role_id');
            $table->string('avatar')->nullable()->after('organization_id'); // Path gambar avatar
            $table->integer('xp')->default(0)->after('avatar'); // Poin pengalaman (XP)
        });
    }

    /**
     * Batalkan migrasi (hapus kolom-kolom yang ditambahkan).
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Hapus kunci asing terlebih dahulu
            $table->dropForeign(['role_id']);
            $table->dropForeign(['organization_id']);
            // Kemudian hapus kolom-kolom
            $table->dropColumn('role_id');
            $table->dropColumn('organization_id');
            $table->dropColumn('avatar');
            $table->dropColumn('xp');
        });
    }
};