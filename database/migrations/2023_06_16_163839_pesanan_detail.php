<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PesananDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pesanan_detail', function (Blueprint $table) {
            $table->increments('id_pesanan_detail');
            $table->integer('id_pesanan');
            $table->string('nama_pesanan');
            $table->integer('id_barang');
            $table->integer('id_bahan');
            $table->integer('harga');
            $table->float('panjang')->nullable();
            $table->float('lebar')->nullable();
            $table->integer('jumlah');
            $table->integer('subtotal');
            $table->integer('id_finishing');
            $table->string('status_detail');
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
        Schema::dropIfExists('pesanan_detail');
    }
}
