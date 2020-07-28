<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReconstructKegiatanProgramKerja extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('mst_program_kerja', 'id_kegiatan')) {
            Schema::table('mst_program_kerja', function (Blueprint $table) {
                $table->integer('id_kegiatan')->default(0)->after("id_skpd");
            });
        }

        if(Schema::hasColumn('mst_program_kerja', 'nama')) {
            Schema::table('mst_program_kerja', function (Blueprint $table) {
                $table->dropColumn('nama');
            });
        }
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
