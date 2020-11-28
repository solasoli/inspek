<?php

namespace App\Repository\Pemeriksaan;

use App\Repository\BaseModel;

class KertasKerjaIkhtisarKodeRekomendasi extends BaseModel
{
  protected $table = "adt_audit_kertas_kerja_ikhtisar_kode_rekomendasi";
  protected $fillable = ['id_kertas_kerja_ikhtisar', 'level', 'id_kode_rekomendasi'];

  public function kertas_kerja_ikhtisar()
  {
    return $this->belongsTo('App\Repository\Pemeriksaan\KertasKerjaIkhtisar', 'id_kertas_kerja_ikhtisar')->where('adt_audit_kertas_kerja_ikhtisar.is_deleted', 0);
  }
  
  public function kode_rekomendasi()
  {
    return $this->belongsTo('App\Repository\Master\KodeRekomendasi', 'id_kode_rekomendasi');
  }
}
