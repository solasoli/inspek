<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdjustmentAngkaKredit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('akr_butir_kegiatan', function (Blueprint $table) {
            $table->decimal('angka_kredit', 8, 3)->change();
            $table->integer('id_jabatan')->after('id_butir_kegiatan_satuan')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('akr_butir_kegiatan', function (Blueprint $table) {
            //
        });
    }
}
