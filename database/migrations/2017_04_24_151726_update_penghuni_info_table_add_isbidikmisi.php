<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePenghuniInfoTableAddIsbidikmisi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_penghuni', function (Blueprint $table) {
            $table->boolean('is_bidikmisi');
        });
        Schema::table('daftar_asrama_reguler', function (Blueprint $table) {
            $table->boolean('is_bidikmisi');
        });
        Schema::table('daftar_asrama_non_reguler', function (Blueprint $table) {
            $table->boolean('is_bidikmisi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_penghuni', function (Blueprint $table) {
            $table->dropColumn('is_bidikmisi');
        });
        Schema::table('daftar_asrama_reguler', function (Blueprint $table) {
            $table->dropColumn('is_bidikmisi');
        });
        Schema::table('daftar_asrama_non_reguler', function (Blueprint $table) {
            $table->dropColumn('is_bidikmisi');
        });
    }
}
