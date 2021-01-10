<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdjustmentTablePkptSuratPerintah extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pkpt_surat_perintah', function (Blueprint $table) {
            $table->dropColumn(['id_wilayah', 'id_inspektur_pembantu', 'id_pengendali_teknis', 'id_ketua_tim']);
            $table->integer('jumlah_team')->default(1)->after('id_inspektur');
            $table->boolean('is_judul_lampiran')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pkpt_surat_perintah', function (Blueprint $table) {
            //
        });
    }
}
