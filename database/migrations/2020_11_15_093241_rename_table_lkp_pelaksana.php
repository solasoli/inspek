<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameTableLkpPelaksana extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('sp_langkah_kerja_pemeriksaan_pelaksana', 'sp_langkah_kerja_pemeriksaan_prosedur_pelaksana');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sp_langkah_kerja_pemeriksaan_pelaksana', function (Blueprint $table) {
            //
        });
    }
}
