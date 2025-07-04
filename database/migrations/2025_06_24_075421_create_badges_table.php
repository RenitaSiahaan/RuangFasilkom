<?php

// database/migrations/YYYY_MM_DD_HHMMSS_create_badges_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('badges', function (Blueprint $table) {
            $table->id();
            $table->string('badge_name')->unique();
            $table->text('description')->nullable();
            $table->string('image_path')->nullable();
            $table->integer('xp_required')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('badges');
    }
};