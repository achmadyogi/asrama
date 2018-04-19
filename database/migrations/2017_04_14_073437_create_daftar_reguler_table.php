<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDaftarRegulerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daftar_asrama_reguler', function (Blueprint $table) {
            $table->increments('id_daftar');
            $table->unsignedInteger('id_user');
            $table->unsignedInteger('id_periode');
            $table->tinyInteger('preference')->comment('1: sendiri. 2: berdua. 3: bertiga');
            $table->boolean('verification')->comment('disahkan atau belum');
            $table->string('status_beasiswa')->comment('bidikmisi, afirmasi, non-beasiswa, atau lainnya');
            $table->string('status_mahasiswa')->comment('ganesha, jatinangor, atau cirebon');
            $table->string('kepenghunian')->comment('tutor, karyawan, lainnya');
            $table->boolean('is_difable');
            $table->boolean('is_international');
            $table->date('tanggal_masuk');
            $table->timestamps();
            $table->foreign('id_user','id_periode')->references('id','id_periode')->on('users','periode');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('daftar_asrama_reguler');
    }
}
