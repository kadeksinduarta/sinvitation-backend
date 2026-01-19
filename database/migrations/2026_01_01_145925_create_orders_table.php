<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('kategori'); // pernikahan, ulang_tahun
            $table->boolean('isi_foto')->default(false);
            $table->string('nama_pemesan');
            $table->string('link_template')->nullable();
            
            // Wedding Specific
            $table->string('susunan_nama_mempelai')->nullable(); // misal: Wanita & Pria
            $table->string('agama')->nullable();
            
            $table->string('nama_panggilan_wanita')->nullable();
            $table->string('nama_lengkap_wanita')->nullable();
            $table->string('nama_ortu_wanita')->nullable();
            $table->string('ig_wanita')->nullable();
            
            $table->string('nama_panggilan_pria')->nullable();
            $table->string('nama_lengkap_pria')->nullable();
            $table->string('nama_ortu_pria')->nullable();
            $table->string('ig_pria')->nullable();
            
            $table->date('tanggal_pernikahan')->nullable();
            $table->string('waktu_pernikahan')->nullable();
            $table->text('alamat_pernikahan')->nullable();
            $table->text('link_lokasi_pernikahan')->nullable();
            
            $table->date('tanggal_resepsi')->nullable();
            $table->string('waktu_resepsi')->nullable();
            $table->text('alamat_resepsi')->nullable();
            $table->text('link_lokasi_resepsi')->nullable();

            // Birthday Specific
            $table->string('nama_ulang_tahun')->nullable();
            $table->string('umur_ke')->nullable();
            $table->date('tanggal_acara_ulang_tahun')->nullable();
            $table->string('waktu_acara_ulang_tahun')->nullable();
            $table->text('alamat_acara_ulang_tahun')->nullable();
            $table->text('link_lokasi_ulang_tahun')->nullable();
            
            // Common
            $table->string('amplop_digital')->nullable();
            $table->string('no_rek')->nullable();
            $table->text('link_drive_foto')->nullable();
            $table->string('lagu')->nullable();
            $table->string('bukti_transfer');
            $table->text('note')->nullable();
            $table->string('status')->default('pending'); // pending, processed, completed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
