<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('room_difficulties', function (Blueprint $table) {
            // Menambahkan kolom 'badge_id'
            // 'nullable()' berarti kolom ini bisa kosong
            // 'constrained('badges')' membuat foreign key ke tabel 'badges'
            // 'onDelete('set null')' berarti jika badge yang direferensikan dihapus, nilai badge_id di sini akan diatur ke NULL
            $table->foreignId('badge_id')
                  ->nullable()
                  ->constrained('badges')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('room_difficulties', function (Blueprint $table) {
            // Menghapus foreign key terlebih dahulu
            $table->dropConstrainedForeignId('badge_id'); // Ini akan mencari foreign key untuk badge_id dan menghapusnya
            // Atau secara eksplisit jika nama constraint kustom: $table->dropForeign(['badge_id']);

            // Menghapus kolom 'badge_id'
            $table->dropColumn('badge_id');
        });
    }
};