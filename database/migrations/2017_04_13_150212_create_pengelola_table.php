<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePengelolaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengelola', function (Blueprint $table) {
            $table->increments('id_pengelola');
            $table->unsignedInteger('id_user');
            $table->unsignedInteger('id_asrama');
            $table->boolean('is_superpengelola');
            $table->foreign('id_user','id_asrama')->references('id','id_asrama')->on('users','asrama')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengelola');
    }
}
