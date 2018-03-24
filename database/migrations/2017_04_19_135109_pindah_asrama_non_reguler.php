<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PindahAsramaNonReguler extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pindah_asrama_non_reguler', function (Blueprint $table) {
            $table->unsignedInteger('id_pendaftaran_non_reguler')->references('id_pendaftaran_non_reguler')->on('pendaftaran_non_reguler');
            $table->string('alasan_pindah');
            $table->string('status_pindah');
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
        Schema::dropIfExists('pindah_asrama_non_reguler');
    }
}
