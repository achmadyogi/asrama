<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeriodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('periodes', function (Blueprint $table) {
            $table->increments('id_periode');
            $table->string('nama_periode');
            $table->date('tanggal_buka_daftar');
            $table->date('tanggal_tutup_daftar');
            $table->date('tanggal_mulai_tinggal');
            $table->date('tanggal_selesai_tinggal');
            $table->integer('jumlah_bulan')->comment('untuk perhitungan tagihan');
            $table->text('keterangan')->comment('informasi tambahan bila perlu');
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
        Schema::dropIfExists('periodes');
    }
}
