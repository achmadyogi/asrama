<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NullableBiodataOrtu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_penghuni', function(Blueprint $table) {
            $table->string('nama_ortu_wali')->nullable()->change();
            $table->string('pekerjaan_ortu_wali')->nullable()->change();
            $table->string('alamat_ortu_wali')->nullable()->change();
            $table->string('telepon_ortu_wali')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_penghuni', function(Blueprint $table) {
            $table->string('nama_ortu_wali')->change();
            $table->string('pekerjaan_ortu_wali')->change();
            $table->string('alamat_ortu_wali')->change();
            $table->string('telepon_ortu_wali')->change();
        });
    }
}
