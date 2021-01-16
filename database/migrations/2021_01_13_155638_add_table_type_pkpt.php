<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTableTypePkpt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pkpt_type_pkpt', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('code');
            $table->dateTime('created_at')->nullable();
            $table->integer('created_by')->default(0);
            $table->dateTime('updated_at')->nullable();
            $table->integer('updated_by')->default(0);
            $table->dateTime('deleted_at')->nullable();
            $table->integer('deleted_by')->default(0);
            $table->boolean('is_deleted')->default(0);
        });

        DB::insert("INSERT INTO `pkpt_type_pkpt` (`id`, `name`, `code`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_at`, `deleted_by`, `is_deleted`) VALUES (1, 'PKPT Tim', 'pkpt_tim', NULL, 0, NULL, 0, NULL, 0, 0);");
        DB::insert("INSERT INTO `pkpt_type_pkpt` (`id`, `name`, `code`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_at`, `deleted_by`, `is_deleted`) VALUES (2, 'PKPT Banyak Tim', 'pkpt_banyak_tim', NULL, 0, NULL, 0, NULL, 0, 0);");
        DB::insert("INSERT INTO `pkpt_type_pkpt` (`id`, `name`, `code`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_at`, `deleted_by`, `is_deleted`) VALUES (3, 'PKPT Non Tim', 'pkpt_non_tim', NULL, 0, NULL, 0, NULL, 0, 0);");
        DB::insert("INSERT INTO `pkpt_type_pkpt` (`id`, `name`, `code`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_at`, `deleted_by`, `is_deleted`) VALUES (4, 'Non-PKPT', 'non_pkpt', NULL, 0, NULL, 0, NULL, 0, 0);");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pkpt_type_pkpt');
    }
}
