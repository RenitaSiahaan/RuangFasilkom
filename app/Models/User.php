<?php

// app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use Notifiable, HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'organization_id',
        'avatar',
        'xp',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    // Bingkai berdasarkan XP
    protected function frameImage(): Attribute
    {
        return Attribute::make(
            get: function () {
                $xp = $this->xp ?? 0;
                if ($xp <= 5) return 'images/level0.png';
                if ($xp <= 30) return 'images/level1.png';
                if ($xp <= 74) return 'images/level2.png';
                if ($xp <= 99) return 'images/level3.png';
                if ($xp >= 100) return 'images/level4.png';
                return 'images/frame_default.png';
            }
        );
    }

    // Badge berdasarkan XP
    public function getBadgeNameAttribute(): string
    {
        $xp = $this->xp ?? 0;
        if ($xp <= 5) return 'Newbie';
        if ($xp <= 30) return 'Beginner';
        if ($xp <= 74) return 'Intermediate';
        if ($xp <= 99) return 'Expert';
        if ($xp >= 100) return 'Legendary';
        return 'Unknown';
    }

    public function getOrganizationNameAttribute(): string
    {
        $this->loadMissing('organization');
        return $this->organization->name ?? 'Solo Player';
    }
}
