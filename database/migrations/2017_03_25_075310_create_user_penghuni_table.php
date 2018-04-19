<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPenghuniTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_penghuni', function (Blueprint $table) {
            $table->increments('id_penghuni');
            $table->unsignedInteger('id_user');
            $table->foreign('id_user')
                ->references('id')->on('users')
                ->onDelete('cascade');
            $table->string('nomor_identitas');
            $table->string('jenis_identitas');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('gol_darah', 2);
            $table->char('jenis_kelamin', 1);
            $table->string('alamat')->comment('nama jalan detail');
            $table->string('kota');
            $table->string('propinsi');
            $table->string('kodepos');
            $table->string('negara');
            $table->string('agama');
            $table->string('pekerjaan');
            $table->string('warga_negara');
            $table->string('telepon');
            $table->string('instansi');
            $table->string('nama_ortu_wali');
            $table->string('pekerjaan_ortu_wali');
            $table->string('alamat_ortu_wali');
            $table->string('telepon_ortu_wali');
            $table->string('kontak_darurat');
            $table->string('status_daftar')->nullable();
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
        Schema::dropIfExists('user_penghuni');
    }
}
