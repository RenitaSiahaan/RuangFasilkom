<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    use HasFactory;

    protected $fillable = [
        'badge_name',
        'description',
        'image_path',
        'xp_required',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_badges')->withPivot('earned_at');
    }
}