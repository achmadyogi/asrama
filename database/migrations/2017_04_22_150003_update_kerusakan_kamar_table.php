<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateKerusakanKamarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('kerusakan_kamar');	
        Schema::create('kerusakan_kamar', function (Blueprint $table) {
            $table->increments('id_kerusakan');
            $table->unsignedInteger('id_kamar');
			$table->foreign('id_kamar')->references('id_kamar')->on('kamar');
			$table->unsignedInteger('id_pelapor');
			$table->foreign('id_pelapor')->references('id')->on('users');
            $table->string('keterangan');
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
        Schema::dropIfExists('kerusakan_kamar');
    }
}
