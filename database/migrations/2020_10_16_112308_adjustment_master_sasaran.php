<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdjustmentMasterSasaran extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mst_sasaran', function (Blueprint $table) {
          $table->dropColumn('id_kegiatan');
          $table->integer('id_program_kerja')->after('nama')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('master_sasaran', function (Blueprint $table) {
            //
        });
    }
}
