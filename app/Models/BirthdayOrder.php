<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BirthdayOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_pemesan',
        'no_hp',
        'isi_foto',
        'link_template',
        'link_drive_foto',
        'lagu',
        'catatan',
        'bukti_tranfer',
        'status',
        'nama_yang_ulang_tahun',
        'ultah_ke',
        'tanggal_acara',
        'waktu_acara',
        'alamat_acara',
        'link_lokasi_acara',
    ];

    protected $casts = [
        'isi_foto' => 'boolean',
    ];
}
