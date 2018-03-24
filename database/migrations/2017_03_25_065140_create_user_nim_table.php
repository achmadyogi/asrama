<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserNimTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_nim', function (Blueprint $table) {
            $table->increments('id_nim');
            $table->unsignedInteger('id_user');
            $table->unsignedInteger('id_fakultas');
            $table->unsignedInteger('id_prodi');
            $table->string('nim');
            $table->boolean('status_nim');
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
        Schema::dropIfExists('user_nim');
    }
}
