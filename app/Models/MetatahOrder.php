<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetatahOrder extends Model
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
        'detail_nama_ortu',
        'jumlah_peserta',
        'data_peserta',
        'tanggal_acara',
        'waktu_acara',
        'alamat_acara',
        'link_lokasi_acara',
        'tanggal_resepsi',
        'waktu_resepsi',
        'alamat_resepsi',
        'link_lokasi_resepsi',
    ];

    protected $casts = [
        'isi_foto' => 'boolean',
        'data_peserta' => 'array',
    ];
}
