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
        Schema::create('metatah_orders', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pemesan');
            $table->string('no_hp')->nullable();
            $table->boolean('isi_foto')->default(false);
            $table->string('link_template');
            $table->text('link_drive_foto')->nullable();
            $table->string('lagu')->nullable();
            $table->text('catatan')->nullable();
            $table->string('bukti_tranfer')->nullable();
            $table->string('status')->default('pending');
            $table->string('detail_nama_ortu')->nullable();
            $table->integer('jumlah_peserta')->nullable();
            $table->json('data_peserta')->nullable();
            $table->date('tanggal_acara')->nullable();
            $table->string('waktu_acara')->nullable();
            $table->text('alamat_acara')->nullable();
            $table->text('link_lokasi_acara')->nullable();
            $table->date('tanggal_resepsi')->nullable();
            $table->string('waktu_resepsi')->nullable();
            $table->text('alamat_resepsi')->nullable();
            $table->text('link_lokasi_resepsi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('metatah_orders');
    }
};
