<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableRkaIndikatorKinerjaDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rka_indikator_kinerja_detail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer("id_indikator_kinerja");
            $table->string("tolak_ukur_kinerja");
            $table->string("target_kinerja");
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
        Schema::dropIfExists('rka_indikator_kinerja_detail');
    }
}
