<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagihanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tagihan', function(Blueprint $table){
            $table->increments('id_tagihan');
            $table->unsignedInteger('daftar_asrama_id')->references('id_daftar','id_daftar')->on('daftar_asrama_non_reguler','daftar_asrama_reguler');
            $table->string('daftar_asrama_type')->comment('laravel model class polymorphic r.');
            $table->integer('jumlah_tagihan');
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
        Schema::dropIfExists('tagihan');
    }
}
