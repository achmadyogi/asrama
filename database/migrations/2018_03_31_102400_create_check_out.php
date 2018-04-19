<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCheckOut extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('checkout', function (Blueprint $table) {
            $table->increments('id_checkout');
            $table->unsignedInteger('daftar_asrama_id')->references('id_daftar','id_daftar')->on('daftar_asrama_non_reguler','daftar_asrama_reguler');
            $table->string('daftar_asrama_type')->comment('laravel model class polymorphic r.');
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
        Schema::dropIfExists('checkout');
    }
}
