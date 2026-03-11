<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'api_key',
        'nama_pengantin',
    ];

    public function rsvps()
    {
        return $this->hasMany(Rsvp::class);
    }
}
