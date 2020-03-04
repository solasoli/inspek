<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeIdInspekturToIrban extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mst_wilayah', function (Blueprint $table) {
            DB::statement("ALTER TABLE mst_wilayah CHANGE id_inspektur id_inspektur_pembantu integer");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mst_wilayah', function (Blueprint $table) {
            //
        });
    }
}
