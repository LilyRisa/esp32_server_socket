<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dsp_presets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // người tạo
            $table->string('name'); // tên preset
            $table->json('eq_data'); // dữ liệu EQ lưu dạng JSON [0, 1, 2, 3,...]
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dsp_presets');
    }
};
