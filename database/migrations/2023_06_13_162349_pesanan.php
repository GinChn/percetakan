<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Pesanan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pesanan', function (Blueprint $table) {
            $table->increments('id_pesanan');
            $table->timestamp('tanggal');
            $table->string('no_nota');
            $table->integer('nama_pelanggan')->nullable();
            $table->integer('no_telp')->nullable();
            $table->integer('total');
            $table->integer('bayar')->default(0);
            $table->integer('diterima')->default(0);
            $table->integer('status_desain')->nullable();
            $table->integer('status_pesanan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pesanan');
    }
}
