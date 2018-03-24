<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermohonanPindahTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permohonan_pindah', function (Blueprint $table) {
            $table->increments('id_permohonan');
            $table->unsignedInteger('id_user');
			$table->foreign('id_user')->references('id')->on('users');
            $table->unsignedInteger('id_kamar_lama');
            $table->unsignedInteger('id_kamar_baru');
            $table->string('alasan');
            $table->date('tanggal_mulai_pindah');
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
        Schema::dropIfExists('permohonan_pindah');
    }
}
