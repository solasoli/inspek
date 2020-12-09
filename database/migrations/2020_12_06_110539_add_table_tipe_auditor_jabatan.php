<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTableTipeAuditorJabatan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pgw_tipe_auditor_jabatan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_tipe_auditor');
            $table->integer('id_jabatan');
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
        Schema::dropIfExists('pgw_tipe_auditor_jabatan');
    }
}
