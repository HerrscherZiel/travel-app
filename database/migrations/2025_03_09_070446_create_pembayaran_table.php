<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('pemesanan_id')->nullable();

            $table->decimal('jumlah_pembayaran', 10, 2);
            $table->enum('status_bayar', ['pending', 'success', 'failed'])->default('pending');
            $table->timestamp('waktu_pembayaran')->nullable();
            $table->string('bukti_pembayaran')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('pemesanan_id')->references('id')->on('pemesanan_tiket')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pembayaran');
    }
};
