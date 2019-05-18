<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePembayaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembayaran', function(Blueprint $table){
            $table->increments('id_pembayaran');
            $table->unsignedInteger('id_tagihan');
            $table->foreign('id_tagihan')->references('id_tagihan')->on('tagihan');
            $table->dateTime('tanggal_bayar')->comment('sesuai tanggal pembayaran bank');
            $table->string('nomor_transaksi')->comment('nomor pada slip pembayaran bank');
            $table->integer('jumlah_bayar');
            $table->boolean('jenis_pembayaran')->comment('0 = host-to-host, 1 = rekening penampungan');
            $table->text('keterangan');
            $table->string('nama_pengirim');
            $table->string('bank_asal');
            $table->boolean('is_accepted');
            $table->text('file');
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
        Schema::dropIfExists('pembayaran');
    }
}
