<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('laporan_penumpang', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('jadwal_travel_id')->nullable();
            $table->integer('jumlah_penumpang')->default(0);
            $table->timestamps();

            $table->foreign('jadwal_travel_id')
                  ->references('id')
                  ->on('jadwal_travel')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('laporan_penumpang');
    }
};
