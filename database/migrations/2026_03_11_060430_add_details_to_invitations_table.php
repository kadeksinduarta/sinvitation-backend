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
        Schema::table('invitations', function (Blueprint $table) {
            $table->string('nama_pria')->nullable();
            $table->string('nama_wanita')->nullable();
            $table->dateTime('tanggal_acara')->nullable();
            // info tambahan lain bisa di tambahkan di text json atau lainnya
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            $table->dropColumn(['nama_pria', 'nama_wanita', 'tanggal_acara']);
        });
    }
};
