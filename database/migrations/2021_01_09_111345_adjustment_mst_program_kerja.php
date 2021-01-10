<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdjustmentMstProgramKerja extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::table('mst_program_kerja', function (Blueprint $table) {
            $table->dropColumn(['id_skpd', 'sub_kegiatan', 'anggaran']);
            $table->integer('id_jenis_pengawasan')->default(0)->after('id');
            $table->text("sasaran")->after('id_kegiatan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
