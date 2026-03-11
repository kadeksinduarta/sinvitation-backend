<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rsvp extends Model
{
    protected $fillable = [
        'invitation_id',
        'nama_tamu',
        'jumlah_kehadiran',
        'status_kehadiran',
    ];

    public function invitation()
    {
        return $this->belongsTo(Invitation::class);
    }
}
