<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CheckOutReguler extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checkout_reguler', function (Blueprint $table) {
            $table->unsignedInteger('id_daftar')->references('id_pendaftaran_reguler')->on('pendaftaran_reguler');
            $table->date('tanggal_masuk');
            $table->date('tanggal_keluar');
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
        Schema::dropIfExists('checkout_reguler');
    }
}
