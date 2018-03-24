<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKeluarAsramaNonRegulerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keluar_asrama_non_reguler', function (Blueprint $table) {
            $table->unsignedInteger('id_pendaftaran_non_reguler')->references('id_pendaftaran_non_reguler')->on('pendaftaran_non_reguler');
            $table->date('tanggal_keluar');
            $table->string('alasan_keluar');
            $table->string('status_keluar');
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
        Schema::dropIfExists('keluar_asrama_non_reguler');
    }
}
