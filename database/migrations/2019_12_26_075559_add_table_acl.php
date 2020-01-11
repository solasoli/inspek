<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTableAcl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
         Schema::create('acl_role', function (Blueprint $table) {
             $table->increments('id');
             $table->string("nama");
             $table->dateTime('created_at')->nullable();
             $table->integer('created_by')->default(0);
             $table->dateTime('updated_at')->nullable();
             $table->integer('updated_by')->default(0);
             $table->dateTime('deleted_at')->nullable();
             $table->integer('deleted_by')->default(0);
             $table->boolean('is_deleted')->default(0);
           });
           Schema::create('acl_menu', function (Blueprint $table) {
             $table->increments('id');
             $table->string("nama");
             $table->string("url");
             $table->string('slug')->nullable();
             $table->dateTime('created_at')->nullable();
             $table->integer('created_by')->default(0);
             $table->dateTime('updated_at')->nullable();
             $table->integer('updated_by')->default(0);
             $table->dateTime('deleted_at')->nullable();
             $table->integer('deleted_by')->default(0);
             $table->boolean('is_deleted')->default(0);
           });
           Schema::create('acl_permission', function (Blueprint $table) {
             $table->increments('id');
             $table->integer("id_menu");
             $table->integer("id_role");
             $table->boolean("view");
             $table->boolean("add");
             $table->boolean("edit");
             $table->boolean("delete");
           });
     }

     /**
      * Reverse the migrations.
      *
      * @return void
      */
     public function down()
     {

         Schema::dropIfExists('acl_role');
         Schema::dropIfExists('acl_menu');
         Schema::dropIfExists('acl_permission');
     }
}
