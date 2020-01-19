<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableRincianAnggaranDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rka_rincian_anggaran_detail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer("id_rincian_anggaran");
            $table->integer("volume");
            $table->integer("id_satuan");
            $table->integer("harga");
            $table->integer("jumlah");
            $table->boolean("is_deleted")->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rka_rincian_anggaran_detail');
    }
}
