<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTableTempKodeRekeningDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('temp_kode_rekening_detail', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->string('row');
          $table->string('value');
          $table->integer('id_kode_rekening');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('temp_kode_rekening_detail');
    }
}
