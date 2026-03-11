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
        Schema::dropIfExists('attendances');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->string('invitation_slug')->index();
            $table->string('guest_name');
            $table->string('attendance');
            $table->text('message')->nullable();
            $table->timestamps();
        });
    }
};
