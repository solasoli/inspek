<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnIsCompilation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('adt_audit_kertas_kerja_ikhtisar', function (Blueprint $table) {
            $table->integer('is_compilation')->length(1)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('adt_audit_kertas_kerja_ikhtisar', function (Blueprint $table) {
            //
        });
    }
}
