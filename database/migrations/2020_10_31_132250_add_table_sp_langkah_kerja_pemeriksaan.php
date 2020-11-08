<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTableSpLangkahKerjaPemeriksaan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sp_langkah_kerja_pemeriksaan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('judul_tugas');
            $table->longText('sub_judul_tugas');
            $table->longText('tujuan_pemeriksaan');
            $table->longText('prosedur_pemeriksaan');
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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sp_langkah_kerja_pemeriksaan');
    }
}
