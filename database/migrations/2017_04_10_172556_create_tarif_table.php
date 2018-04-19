<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTarifTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('tarif', function (Blueprint $table) {
          $table->increments('id_tarif');
          $table->unsignedInteger('id_asrama');
          $table->foreign('id_asrama')->references('id_asrama')->on('asrama');
          $table->integer('kapasitas_kamar');
          $table->string('tempo')->comment('bulanan/harian');
          $table->integer('tarif_sarjana')->nullable();
          $table->integer('tarif_pasca_sarjana')->nullable();
          $table->integer('tarif_international')->nullable();
          $table->integer('tarif_umum')->nullable();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tarif');
    }
}
