<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePengumumanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('pengumuman', function (Blueprint $table) {
          $table->increments('id_pengumuman');
          $table->unsignedInteger('id_penulis');
          $table->foreign('id_penulis')->references('id')->on('users');
          $table->string('title');
          $table->text('isi');
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
        Schema::dropIfExists('pengumuman');
    }
}
