<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AllowReviewSingkatNull extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('adt_audit_kertas_kerja_review', function (Blueprint $table) {
            $table->text('uraian_singkat')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('adt_audit_kertas_kerja_review', function (Blueprint $table) {
            //
        });
    }
}
