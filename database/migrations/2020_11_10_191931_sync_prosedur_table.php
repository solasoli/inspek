<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SyncProsedurTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('sp_langkah_kerja_pemeriksaan_uraian', 'sp_langkah_kerja_pemeriksaan_prosedur');
        Schema::rename('sp_langkah_kerja_pemeriksaan_uraian_detail', 'sp_langkah_kerja_pemeriksaan_prosedur_detail');
        
        Schema::table('sp_langkah_kerja_pemeriksaan_prosedur', function (Blueprint $table) {
            $table->renameColumn('uraian', 'prosedur');
        });
        
        Schema::table('sp_langkah_kerja_pemeriksaan_prosedur_detail', function (Blueprint $table) {
            $table->renameColumn('id_uraian', 'id_prosedur');
            $table->renameColumn('uraian_detail', 'prosedur_detail');
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
