<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('device_dsp_links', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('device_id');
            $table->unsignedBigInteger('dsp_preset_id')->nullable(); // preset đang dùng
            $table->timestamps();

            $table->foreign('device_id')->references('id')->on('devices')->onDelete('cascade');
            $table->foreign('dsp_preset_id')->references('id')->on('dsp_presets')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('device_dsp_links');
    }
};