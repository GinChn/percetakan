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
            $table->string('nama_pelanggan')->nullable();
            $table->char('no_telp', 13)->nullable();
            $table->integer('total');
            $table->integer('bayar')->default(0);
            $table->integer('diterima')->default(0);
            $table->string('status_desain')->nullable();
            $table->string('status_pesanan')->nullable();
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
