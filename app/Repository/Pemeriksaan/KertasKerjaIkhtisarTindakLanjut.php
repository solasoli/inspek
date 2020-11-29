<?php

namespace App\Repository\Pemeriksaan;

use App\Repository\BaseModel;

class KertasKerjaIkhtisarTindakLanjut extends BaseModel
{
  protected $table = "adt_audit_kertas_kerja_ikhtisar_tindak_lanjut";

  public function kertas_kerja_ikhtisar()
  {
    return $this->belongsTo('App\Repository\Pemeriksaan\KertasKerjaIkhtisar', 'id_kertas_kerja_ikhtisar')->where('adt_audit_kertas_kerja_ikhtisar.is_deleted', 0);
  }

}
