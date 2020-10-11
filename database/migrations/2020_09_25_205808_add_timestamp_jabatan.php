<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTimestampJabatan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pgw_jabatan', function (Blueprint $table) {
            
            $table->dateTime('created_at')->nullable();
            $table->integer('created_by')->default(0);
            $table->dateTime('updated_at')->nullable();
            $table->integer('updated_by')->default(0);
            $table->dateTime('deleted_at')->nullable();
            $table->integer('deleted_by')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pgw_jabatan', function (Blueprint $table) {
            //
        });
    }
}
