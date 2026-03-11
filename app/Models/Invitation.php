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
        'client_name',
        'nama_pria',
        'nama_wanita',
        'tanggal_acara'
    ];

    public function rsvps()
    {
        return $this->hasMany(Rsvp::class);
    }
}
