<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdSpLkpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sp_langkah_kerja_pemeriksaan', function (Blueprint $table) {
            $table->integer('id_surat_perintah')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sp_langkah_kerja_pemeriksaan', function (Blueprint $table) {
            //
        });
    }
}
