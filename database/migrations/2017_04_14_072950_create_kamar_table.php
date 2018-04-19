<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKamarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kamar', function (Blueprint $table) {
            $table->increments('id_kamar');
            $table->unsignedInteger('id_gedung');
            $table->foreign('id_gedung')->references('id_gedung')->on('gedung');
            $table->string('nama');
            $table->integer('kapasitas');
            $table->boolean('status')->comment('dapat ditinggali atau tidak');
            $table->text('keterangan');
            $table->char('gender',1)->comment('L/P');
            $table->tinyInteger('which_user')->comment('1:reguler. 2:international. 3:tamu');
            $table->boolean('is_difable');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kamar');
    }
}
