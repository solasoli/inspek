<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableRkaRincianAnggaran extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rka_rincian_anggaran', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer("id_kode_rekening");
            $table->integer("jumlah");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rka_rincian_anggaran');
    }
}
