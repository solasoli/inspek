<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTableDevConfigDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dev_config_detail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('label');
            $table->string('column_in_db');
            $table->integer('id_config');
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
        Schema::dropIfExists('dev_config_detail');
    }
}
