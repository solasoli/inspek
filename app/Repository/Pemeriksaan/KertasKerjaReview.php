<?php

namespace App\Repository\Pemeriksaan;

use App\Repository\BaseModel;

class KertasKerjaReview extends BaseModel
{
  protected $table = "adt_audit_kertas_kerja_review";
  protected $fillable = [
    'id_kertas_kerja', 
    'uraian_singkat', 
    'tipe'
  ];

  public function kertas_kerja()
  {
    return $this->belongsTo('App\Repository\Pemeriksaan\KertasKerja', 'id_kertas_kerja');
  }

}
