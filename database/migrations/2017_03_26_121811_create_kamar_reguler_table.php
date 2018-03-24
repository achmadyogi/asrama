<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKamarRegulerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kamar_reguler', function (Blueprint $table) {
            $table->unsignedInteger('id_pendaftaran_reguler')->references('id_pendaftaran_reguler')->on('pendaftaran_reguler');
            $table->unsignedInteger('id_kamar')->references('id_kamar')->on('kamar');
            $table->date('tanggal_awal');
            $table->date('tanggal_akhir')->nullable();
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
        Schema::dropIfExists('kamar_reguler');
    }
}
