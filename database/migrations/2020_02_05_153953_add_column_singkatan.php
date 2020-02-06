<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnSingkatan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mst_skpd', function (Blueprint $table) {
            $table->string("singkatan_pd")->nullable()->after("name");
            $table->string("singkatan_pimpinan")->nullable()->after("singkatan_pd");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mst_skpd', function (Blueprint $table) {
            //
        });
    }
}
