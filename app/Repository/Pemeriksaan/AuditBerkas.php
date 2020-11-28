<?php

namespace App\Repository\Pemeriksaan;

use App\Repository\BaseModel;

class AuditBerkas extends BaseModel
{
  protected $table = "adt_audit_berkas";
  protected $fillable = ['id_kertas_kerja','file_url'];

  public function kertas_kerja()
  {
    return $this->belongsTo('App\Repository\Pemeriksaan\KertasKerja', 'id_kertas_kerja');
  }

}
