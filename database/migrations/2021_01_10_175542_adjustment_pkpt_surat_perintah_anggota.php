<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdjustmentPkptSuratPerintahAnggota extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pkpt_surat_perintah_anggota', function (Blueprint $table) {
            $table->integer('id_surat_perintah_tim')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pkpt_surat_perintah_anggota', function (Blueprint $table) {
            //
        });
    }
}
