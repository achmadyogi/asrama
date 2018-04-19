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
            $table->unsignedInteger('id_kamar_lama');
            $table->unsignedInteger('id_kamar_baru');
            $table->text('alasan');
            $table->date('tanggal_mulai_pindah');
            $table->boolean('verification')->comment('whether or not aggreed');
            $table->timestamps();
            $table->foreign('id_user','id_kamar_lama','id_kamar_baru')->references('id','id_kamar','id_kamar')->on('users','kamar','kamar')->onDelete('cascade');
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
