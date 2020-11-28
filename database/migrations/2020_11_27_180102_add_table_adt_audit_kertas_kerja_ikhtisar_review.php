<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTableAdtAuditKertasKerjaIkhtisarReview extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adt_audit_kertas_kerja_ikhtisar_review', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_kertas_kerja_ikhtisar');
            $table->text('judul_kondisi')->nullable();
            $table->text('uraian_kondisi')->nullable();
            $table->text('kriteria')->nullable();
            $table->text('sebab')->nullable();
            $table->text('akibat')->nullable();
            $table->text('rekomendasi')->nullable();
            $table->string('tipe');
            $table->dateTime('created_at')->nullable();
            $table->integer('created_by')->default(0);
            $table->dateTime('updated_at')->nullable();
            $table->integer('updated_by')->default(0);
            $table->dateTime('deleted_at')->nullable();
            $table->integer('deleted_by')->default(0);
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
        //
    }
}
