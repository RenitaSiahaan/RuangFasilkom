<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'room_id',
        'start_time',
        'end_time',
        'purpose',
        'is_for_student',
        'student_letter_path',
        'status_id',
        'rejection_reason',
        'tu_approval_at',
        'wadek_approval_at',
        'permission_letter_path',
        'lpj_path',
        'cancellation_reason',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'tu_approval_at' => 'datetime',
        'wadek_approval_at' => 'datetime',
        'is_for_student' => 'boolean',
    ];

    /**
     * Dapatkan pengguna (User) yang melakukan peminjaman ini.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Dapatkan ruangan (Room) yang dipinjam.
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Dapatkan status (BookingStatus) dari peminjaman ini.
     */
    public function status()
    {
        return $this->belongsTo(BookingStatus::class, 'status_id');
    }
}