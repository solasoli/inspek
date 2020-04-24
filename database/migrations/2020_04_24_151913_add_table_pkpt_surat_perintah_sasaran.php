<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTablePkptSuratPerintahSasaran extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('pkpt_surat_perintah_sasaran', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->integer("id_surat_perintah");
          $table->integer("id_sasaran");
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
        Schema::dropIfExists('pkpt_surat_perintah_sasaran');
    }
}
