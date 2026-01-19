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
        Schema::table('wedding_orders', function (Blueprint $table) {
            $table->string('no_hp')->nullable()->after('nama_pemesan');
            $table->text('catatan')->nullable()->after('lagu');
        });

        Schema::table('birthday_orders', function (Blueprint $table) {
            $table->string('no_hp')->nullable()->after('nama_pemesan');
            $table->text('catatan')->nullable()->after('lagu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wedding_orders', function (Blueprint $table) {
            $table->dropColumn(['no_hp', 'catatan']);
        });

        Schema::table('birthday_orders', function (Blueprint $table) {
            $table->dropColumn(['no_hp', 'catatan']);
        });
    }
};
