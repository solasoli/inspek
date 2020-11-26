<?php

namespace App\Repository\Pemeriksaan;

use App\Repository\BaseModel;

class AuditBerkas extends BaseModel
{
  protected $table = "adt_audit_berkas";
  protected $fillable = ['id_surat_perintah','file_url'];

  public function surat_perintah()
  {
    return $this->belongsTo('App\Repository\SuratPerintah\SuratPerintah', 'id_surat_perintah')->where('pkpt_surat_perintah.is_deleted', 0);
  }

}
