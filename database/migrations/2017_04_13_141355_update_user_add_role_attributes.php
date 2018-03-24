<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUserAddRoleAttributes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function(Blueprint $table)
        {
            $table->boolean('is_penghuni');
            $table->boolean('is_pengelola');
            $table->boolean('is_sekretariat');
            $table->boolean('is_pimpinan');
            $table->boolean('is_admin');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function(Blueprint $table)
        {
            $table->dropColumn('is_penghuni');
            $table->dropColumn('is_pengelola');
            $table->dropColumn('is_sekretariat');
            $table->dropColumn('is_pimpinan');
            $table->dropColumn('is_admin');
        });
    }
}
