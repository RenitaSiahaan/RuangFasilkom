<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class RoomDifficulty extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'xp_reward',
        'badge_id', 
    ];

    // Relasi ke Badge
    public function badge(): BelongsTo
    {
        return $this->belongsTo(Badge::class);
    }
}