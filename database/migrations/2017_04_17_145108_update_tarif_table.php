<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTarifTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::dropIfExists('tarif');
    Schema::create('tarif', function (Blueprint $table) {
        $table->increments('id_tarif');
        $table->string('jenis_penyewaan');
        $table->string('asrama');
        $table->unsignedInteger('nilai_tarif_TPB_BM')->nullable();
        $table->unsignedInteger('nilai_tarif_TPB_NBM')->nullable();
        $table->unsignedInteger('nilai_tarif_PS')->nullable();
        $table->unsignedInteger('nilai_tarif_IT')->nullable();
        $table->unsignedInteger('nilai_tarif_NON')->nullable();
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
