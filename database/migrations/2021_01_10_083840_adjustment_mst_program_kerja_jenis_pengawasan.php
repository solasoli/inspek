<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdjustmentMstProgramKerjaJenisPengawasan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mst_program_kerja', function (Blueprint $table) {
            $table->dropColumn('id_jenis_pengawasan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mst_program_kerja', function (Blueprint $table) {
            //
        });
    }
}
