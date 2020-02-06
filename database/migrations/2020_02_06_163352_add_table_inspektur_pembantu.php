<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTableInspekturPembantu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_inspektur_pembantu', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer("id_wilayah");
            $table->integer("id_inspektur_pembantu");
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
        Schema::dropIfExists('mst_inspektur_pembantu');
    }
}
