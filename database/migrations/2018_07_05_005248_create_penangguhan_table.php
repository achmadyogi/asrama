<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePenangguhanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penangguhan', function(Blueprint $table){
            $table->increments('id_penangguhan');
            $table->foreign('id_pembayaran')->references('id_pembayaran')->on('pembayaran');
            $table->integer('jumlah_tangguhan');
            $table->text('alasan_penangguhan');
            $table->dateTime('deadline_pembayaran')->comment('Deadline untuk melunasi penangguhan');
            $table->boolean('is_sktm')->comment('syarat surat keterangan tidak mampu');
            $table->boolean('formulir_penangguhan');
            $table->boolean('is_bayar');
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
        Schema::dropIfExists('penangguhan');
    }
}
