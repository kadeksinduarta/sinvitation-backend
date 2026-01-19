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
        Schema::create('birthday_orders', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal')->nullable();
            $table->boolean('isi_foto')->default(false);
            $table->string('nama_pemesan');
            $table->string('link_template')->nullable();
            
            // Birthday specific
            $table->string('nama_yang_ulang_tahun')->nullable();
            $table->string('ultah_ke')->nullable(); // e.g., "17th", "Sweet Seventeen", "1"
            
            // Acara
            $table->date('tanggal_acara')->nullable();
            $table->string('waktu_acara')->nullable();
            $table->text('alamat_acara')->nullable();
            $table->text('link_lokasi_acara')->nullable();

            // Additional
            $table->text('link_drive_foto')->nullable();
            $table->string('lagu')->nullable();
            $table->string('bukti_tranfer')->nullable();
            
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('birthday_orders');
    }
};
