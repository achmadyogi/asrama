<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKerusakanKamarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kerusakan_kamar', function (Blueprint $table) {
            $table->increments('id_kerusakan');
            $table->unsignedInteger('id_pelapor');
            $table->unsignedInteger('id_kamar');
            $table->string('keterangan');
            $table->boolean('status')->comment('whether or not repaired');
            $table->timestamps();
            $table->foreign('id_pelapor','id_kamar')->references('id','id_kamar')->on('users','kamar')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kerusakan_kamar');
    }
}
