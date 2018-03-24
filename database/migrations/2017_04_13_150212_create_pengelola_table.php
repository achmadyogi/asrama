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
            $table->unsignedInteger('id_user');
            $table->unsignedInteger('id_asrama');
            $table->foreign('id_user')
                ->references('id')->on('users')
                ->onDelete('cascade');
            $table->foreign('id_asrama')
                ->references('id_asrama')->on('asrama')
                ->onDelete('cascade');
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
