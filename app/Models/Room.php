<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'location', 'description', 'capacity', 'difficulty_id', 'image'
    ];

    /**
     * Dapatkan tingkat kesulitan (RoomDifficulty) ruangan ini.
     */
    public function difficulty()
    {
        return $this->belongsTo(RoomDifficulty::class, 'difficulty_id');
    }

    /**
     * Dapatkan semua peminjaman ruangan (RoomBooking) yang terkait dengan ruangan ini.
     */
    public function roomBookings()
    {
        return $this->hasMany(RoomBooking::class);
    }
}