<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingStatus extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * Dapatkan semua peminjaman ruangan (RoomBooking) yang memiliki status ini.
     */
    public function roomBookings()
    {
        return $this->hasMany(RoomBooking::class);
    }
}