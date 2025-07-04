<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * Dapatkan semua pengguna (User) yang tergabung dalam organisasi ini.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}