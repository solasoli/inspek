<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUraianRincianAnggaranDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rka_rincian_anggaran_detail', function (Blueprint $table) {
            $table->string("uraian")->after("id_rincian_anggaran");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rka_rincian_anggaran_detail', function (Blueprint $table) {
            //
        });
    }
}
