<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateColumnIdRkaIndikatorKinerja extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rka_indikator_kinerja', function (Blueprint $table) {
            $table->integer("id_rka")->after("id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rka_indikator_kinerja', function (Blueprint $table) {
            //
        });
    }
}
