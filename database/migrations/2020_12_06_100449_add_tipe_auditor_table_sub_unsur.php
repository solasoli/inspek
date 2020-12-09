<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTipeAuditorTableSubUnsur extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('akr_sub_unsur', function (Blueprint $table) {
            $table->integer('id_tipe_auditor')->after('id_unsur')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('akr_sub_unsur', function (Blueprint $table) {
            //
        });
    }
}
