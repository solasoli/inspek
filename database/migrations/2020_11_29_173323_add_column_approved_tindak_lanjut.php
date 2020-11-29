<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnApprovedTindakLanjut extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pkpt_surat_perintah', function (Blueprint $table) {
            $table->integer('is_approved_tindak_lanjut')->default(0)->length(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pkpt_surat_perintah', function (Blueprint $table) {
            //
        });
    }
}
