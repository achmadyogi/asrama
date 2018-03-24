<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKamarsTable extends Migration
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
            $table->string('nama')->unique();
            $table->integer('kapasitas');
            $table->string('status');
            $table->char('gender');
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
