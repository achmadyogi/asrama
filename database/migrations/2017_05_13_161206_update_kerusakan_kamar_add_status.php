<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateKerusakanKamarAddStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kerusakan_kamar', function (Blueprint $table) {
            $table->string('status')->default('Belum Ditangani');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kerusakan_kamar', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
