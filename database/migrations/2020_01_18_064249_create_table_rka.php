<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableRka extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rka_rka', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer("id_urusan_pemerintahan");
            $table->integer("id_organisasi");
            $table->string("lokasi_kegiatan");
            $table->string("waktu_pelaksanaan");
            $table->string("sumber_dana");
            $table->integer("n_min");
            $table->integer("n");
            $table->integer("n_max");
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
        Schema::dropIfExists('rka_rka');
    }
}
