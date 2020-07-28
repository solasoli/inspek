<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddComponentProgramKerja extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mst_program_kerja', function (Blueprint $table) {
            $table->integer('anggaran')->after('type_pkpt')->default(0);
            $table->integer('jml_wakil_penanggung_jawab')->after('type_pkpt')->default(1);
            $table->integer('jml_pengendali_teknis')->after('jml_wakil_penanggung_jawab')->default(1);
            $table->integer('jml_ketua_tim')->after('jml_pengendali_teknis')->default(1);
            $table->integer('jml_anggota')->after('jml_ketua_tim')->default(1);
            $table->integer('jml_man_power')->after('jml_anggota')->default(1);            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mst_program_kerja', function (Blueprint $table) {
            //
        });
    }
}
