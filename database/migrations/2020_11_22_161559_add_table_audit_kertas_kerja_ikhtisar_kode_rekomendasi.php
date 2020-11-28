<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTableAuditKertasKerjaIkhtisarKodeRekomendasi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adt_audit_kertas_kerja_ikhtisar_kode_rekomendasi', function (Blueprint $table) {          
            $table->bigIncrements('id');
            $table->integer('id_surat_perintah');
            $table->integer('id_kode_rekomendasi');
            $table->integer('level');
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
        Schema::dropIfExists('adt_audit_kertas_kerja_ikhtisar_kode_rekomendasi');
    }
}
