<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnHaveChildLevelAclMenu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('acl_menu', function (Blueprint $table) {
          $table->boolean('have_child')->after('id_parent')->default(0);
          $table->integer('level')->after('have_child')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('acl_menu', function (Blueprint $table) {
            //
        });
    }
}
