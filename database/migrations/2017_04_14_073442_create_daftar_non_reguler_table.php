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
            $table->string('nomor_identitas');
            $table->string('jenis_identitas');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('gol_darah', 2);
            $table->char('jenis_kelamin', 1);
            $table->string('alamat');
            $table->string('agama');
            $table->string('pekerjaan');
            $table->string('warga_negara');
            $table->string('telepon');
            $table->string('instansi');
            $table->string('nama_ortu_wali')->nullable();
            $table->string('pekerjaan_ortu_wali')->nullable();
            $table->string('alamat_ortu_wali')->nullable();
            $table->string('telepon_ortu_wali')->nullable();
            $table->string('kontak_darurat');
            $table->string('asrama');
            $table->date('tanggal_masuk');
            $table->date('tanggal_keluar');
            $table->string('status');
			$table->string('status_penghuni');
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
