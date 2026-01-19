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
        Schema::create('wedding_orders', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal')->nullable();
            $table->boolean('isi_foto')->default(false);
            $table->string('nama_pemesan');
            $table->string('link_template')->nullable();
            $table->string('susunan_nama_mempelai')->nullable();
            $table->string('agama')->nullable();
            
            // Wanita
            $table->string('nama_panggilan_wanita')->nullable();
            $table->string('nama_lengkap_wanita')->nullable();
            $table->string('nama_ortu_wanita')->nullable();
            $table->string('ig_wanita')->nullable();

            // Pria
            $table->string('nama_panggilan_pria')->nullable();
            $table->string('nama_lengkap_pria')->nullable();
            $table->string('nama_ortu_pria')->nullable();
            $table->string('ig_pria')->nullable();

            // Pernikahan (Akad/Pemberkatan)
            $table->date('tanggal_pernikahan')->nullable();
            $table->string('waktu_pernikahan')->nullable();
            $table->text('alamat_pernikahan')->nullable();
            $table->text('link_lokasi_pernikahan')->nullable();

            // Resepsi
            $table->date('tanggal_resepsi')->nullable();
            $table->string('waktu_resepsi')->nullable();
            $table->text('alamat_resepsi')->nullable();
            $table->text('link_lokasi_resepsi')->nullable();

            // Additional
            $table->boolean('amplop_digital')->default(false);
            $table->string('no_rek')->nullable();
            $table->text('link_drive_foto')->nullable();
            $table->string('lagu')->nullable();
            $table->string('bukti_tranfer')->nullable(); // Path to file
            
            $table->string('status')->default('pending'); // pending, approved, rejected
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wedding_orders');
    }
};
