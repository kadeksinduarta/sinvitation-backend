<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeddingOrder extends Model
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
        'nama_lengkap_pria',
        'nama_panggilan_pria',
        'nama_ortu_pria',
        'ig_pria',
        'nama_lengkap_wanita',
        'nama_panggilan_wanita',
        'nama_ortu_wanita',
        'ig_wanita',
        'tanggal_pernikahan',
        'waktu_pernikahan',
        'alamat_pernikahan',
        'link_lokasi_pernikahan',
        'tanggal_resepsi',
        'waktu_resepsi',
        'alamat_resepsi',
        'link_lokasi_resepsi',
    ];

    protected $casts = [
        'isi_foto' => 'boolean',
    ];
}
