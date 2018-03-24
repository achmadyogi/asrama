<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PindahAsramaReguler extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pindah_asrama_reguler', function (Blueprint $table) {
            $table->unsignedInteger('id_pendaftaran_reguler')->references('id_pendaftaran_reguler')->on('pendaftaran_reguler');
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
        Schema::dropIfExists('pindah_asrama_reguler');
    }
}
