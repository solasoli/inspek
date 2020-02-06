<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTablePegawai extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pgw_pegawai', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_skpd');
            $table->bigInteger('id_eselon');
            $table->bigInteger('id_pangkat');
            $table->bigInteger('id_pangkat_golongan');
            $table->bigInteger('id_jabatan');
            $table->integer('id_level');
            $table->string('nip');
            $table->string('nama');
            $table->string('nama_asli');
            $table->string('jenjab');
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
        Schema::dropIfExists('pgw_pegawai');
    }
}
