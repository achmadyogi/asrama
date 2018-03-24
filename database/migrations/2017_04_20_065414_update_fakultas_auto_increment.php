<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFakultasAutoIncrement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('prodi');
        Schema::dropIfExists('fakultas');
        Schema::create('prodi', function (Blueprint $table) {
            $table->increments('id_prodi');
            $table->string('nim_prodi');
            $table->unsignedInteger('nim_fakultas');
            $table->string('nama');
            $table->string('strata');
        });
        Schema::create('fakultas', function (Blueprint $table) {
            $table->increments('id_fakultas');
            $table->string('nama');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prodi');
        Schema::dropIfExists('fakultas');
    }
}
