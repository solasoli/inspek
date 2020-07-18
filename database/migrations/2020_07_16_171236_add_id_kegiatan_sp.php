<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdKegiatanSp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pkpt_surat_perintah', function (Blueprint $table) {
            $table->integer('id_kegiatan')->default(0)->after("id_program_kerja");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pkpt_surat_perintah', function (Blueprint $table) {
            //
        });
    }
}
