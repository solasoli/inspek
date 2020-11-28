<?php

namespace App\Repository\Pemeriksaan;

use App\Repository\BaseModel;

class KertasKerjaIkhtisarKodeTemuan extends BaseModel
{
  protected $table = "adt_audit_kertas_kerja_ikhtisar_kode_temuan";
  protected $fillable = ['id_kertas_kerja_ikhtisar', 'level', 'id_kode_temuan','tipe'];

  public function kertas_kerja_ikhtisar()
  {
    return $this->belongsTo('App\Repository\Pemeriksaan\KertasKerjaIkhtisar', 'id_kertas_kerja_ikhtisar')->where('adt_audit_kertas_kerja_ikhtisar.is_deleted', 0);
  }

  public function kode_temuan()
  {
    return $this->belongsTo('App\Repository\Master\KodeTemuan', 'id_kode_temuan');
  }
}
