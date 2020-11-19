<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTableLkpPelaksana extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sp_langkah_kerja_pemeriksaan_pelaksana', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_prosedur');
            $table->integer('id_pelaksana_rencana');
            $table->integer('id_pelaksana_realisasi');
            $table->integer('durasi_rencana');
            $table->integer('durasi_realisasi');
            $table->dateTime('created_at')->nullable();
            $table->integer('created_by')->default(0);
            $table->dateTime('updated_at')->nullable();
            $table->integer('updated_by')->default(0);
            $table->dateTime('deleted_at')->nullable();
            $table->integer('deleted_by')->default(0);
            $table->boolean('is_deleted')->default(0);
        });

        
        Schema::table('sp_langkah_kerja_pemeriksaan', function (Blueprint $table) {

            $table->dropColumn('id_pelaksana_rencana');
            $table->dropColumn('id_pelaksana_realisasi');
            $table->dropColumn('durasi_rencana');
            $table->dropColumn('durasi_realisasi');
        });
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
