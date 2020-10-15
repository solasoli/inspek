<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropColumnIdSkpdIdProgramKerja extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mst_kegiatan', function (Blueprint $table) {
          $table->dropColumn(['id_skpd', 'id_program_kerja']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mst_kegiatan', function (Blueprint $table) {
            //
        });
    }
}
