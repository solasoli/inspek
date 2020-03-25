<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnIdWilayahTablePegawai extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pgw_pegawai', function (Blueprint $table) {
            $table->integer("id_wilayah")->default(1)->after('id_peran')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pgw_pegawai', function (Blueprint $table) {
            //
        });
    }
}
