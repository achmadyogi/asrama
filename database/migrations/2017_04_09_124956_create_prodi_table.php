<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProdiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prodi', function (Blueprint $table) {
            $table->unsignedInteger('id_prodi')->primary();
            $table->unsignedInteger('id_fakultas');
            $table->foreign('id_fakultas')->references('id_fakultas')->on('fakultas');
            $table->string('nama_prodi');
            $table->tinyInteger('strata')->comment('1:Sarjana, 2:Magister, 3:Profesi');
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
    }
}
