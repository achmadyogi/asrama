<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateDaftarAsramaRegulerAddNamaPeriode extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('daftar_asrama_reguler', function(Blueprint $table)
        {
            $table->string('nama_periode');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('daftar_asrama_reguler', function(Blueprint $table)
        {
            $table->dropColumn('nama_periode');
        });
    }
}
