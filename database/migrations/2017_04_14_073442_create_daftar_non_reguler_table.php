<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDaftarNonRegulerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daftar_asrama_non_reguler', function (Blueprint $table) {
            $table->increments('id_daftar');
            $table->unsignedInteger('id_user');
            $table->foreign('id_user')->references('id')->on('users');
            $table->text('tujuan_tinggal');
            $table->tinyInteger('preference')->comment('1: sendiri. 2: berdua. 3: bertiga');
            $table->string('lokasi_asrama')->comment('rencana tinggal di ganesha atau jatinangor');
            $table->boolean('verification')->comment('disahkan atau belum');
            $table->boolean('is_difable');
            $table->date('tanggal_masuk');
            $table->string('tempo')->comment('harian/bulanan');
            $table->integer('lama_tinggal')->comment('angka kelipatan tempo');
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
        Schema::dropIfExists('daftar_asrama_non_reguler');
    }
}
