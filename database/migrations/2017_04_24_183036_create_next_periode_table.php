<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNextPeriodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('next_periode', function (Blueprint $table) {
            $table->unsignedInteger('periode_asal');
            $table->foreign('periode_asal')->references('id_periode')->on('periodes');
            $table->unsignedInteger('periode_akhir');
            $table->foreign('periode_akhir')->references('id_periode')->on('periodes');
            $table->date('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('next_periode');
    }
}
