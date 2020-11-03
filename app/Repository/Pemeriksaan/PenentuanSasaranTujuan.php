<?php

namespace App\Repository\Pemeriksaan;

use Illuminate\Database\Eloquent\Model;

class PenentuanSasaranTujuan extends Model
{
  protected $table = "sp_penentuan_sasaran_tujuan";

  public function surat_perintah()
  {
    return $this->belongsTo('App\Repository\SuratPerintah\SuratPerintah', 'id_surat_perintah')->where('pkpt_surat_perintah.is_deleted', 0);
  }

  public function sasaran_tujuan()
  {
    return $this->belongsTo('App\Repository\Master\SasaranTujuan', 'id_sasaran_tujuan')->where('mst_sasaran_tujuan.is_deleted', 0);
  }
}
