<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnProgramKegiatanTableRka extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rka_rka', function (Blueprint $table) {
            $table->integer("id_program")->after("id_organisasi");
            $table->integer("id_kegiatan")->after("id_program");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rka_rka', function (Blueprint $table) {
            //
        });
    }
}
