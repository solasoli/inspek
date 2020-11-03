<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyColumnIsiSpPenentuanSasaranTujuan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sp_penentuan_sasaran_tujuan', function (Blueprint $table) {
          $table->longText('isi')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sp_penentuan_sasaran_tujuan', function (Blueprint $table) {
            //
        });
    }
}
