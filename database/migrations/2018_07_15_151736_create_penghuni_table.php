<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePenghuniTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penghuni', function(Blueprint $table){
            $table->increments('id_penghuni');
            $table->foreign('id_user')->references('id_user')->on('users');
            $table->integer('surat_perjanjian');
            $table->text('ktm');
            $table->dateTime('keterangan')->comment('Deadline untuk melunasi penangguhan');
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
        Schema::dropIfExists('penghuni');
    }
}
