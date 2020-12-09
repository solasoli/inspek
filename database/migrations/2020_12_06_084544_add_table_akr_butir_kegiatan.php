<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTableAkrButirKegiatan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('akr_butir_kegiatan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_sub_unsur');
            $table->string('nama');
            $table->integer('angka_kredit');
            $table->tinyInteger('is_all_jenjang');
            $table->integer('id_butir_kegiatan_satuan');
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
        Schema::dropIfExists('akr_butir_kegiatan');
    }
}
