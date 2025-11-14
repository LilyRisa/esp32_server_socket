<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeviceEqsTable extends Migration
{
    public function up()
    {
        Schema::create('device_eqs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('device_code')->index();
            // Các tham số bổ sung (nullable để trong tương lai có thể chưa set)
            $table->tinyInteger('clarity')->nullable();
            $table->tinyInteger('ambience')->nullable();
            $table->tinyInteger('surround')->nullable();
            $table->tinyInteger('dynamic_boost')->nullable();
            $table->tinyInteger('bass_boost')->nullable();

            // Lưu mảng EQ 10-band (dùng JSON)
            $table->json('eq')->nullable();

            $table->timestamps();
            $table->unique(['device_code']); // mỗi device_code chỉ 1 bản ghi
        });
    }

    public function down()
    {
        Schema::dropIfExists('device_eqs');
    }
}