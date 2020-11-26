<?php

namespace App\Repository\Pemeriksaan;

use App\Repository\BaseModel;

class KertasKerja extends BaseModel
{
  protected $table = "adt_audit_kertas_kerja";
  protected $fillable = ['id_surat_perintah','uraian_singkat'];

  public function surat_perintah()
  {
    return $this->belongsTo('App\Repository\SuratPerintah\SuratPerintah', 'id_surat_perintah')->where('pkpt_surat_perintah.is_deleted', 0);
  }

}
