<?php

namespace App\Repository\Pemeriksaan;

use App\Repository\BaseModel;

class KertasKerjaIkhtisarReview extends BaseModel
{
  protected $table = "adt_audit_kertas_kerja_ikhtisar_review";
  protected $fillable = ['id_kertas_kerja_ikhtisar', 
  'uraian_singkat', 
  'judul_kondisi', 
  'uraian_kondisi', 
  'kriteria', 
  'sebab', 
  'akibat', 
  'rekomendasi',
  'tipe'];

  public function kertas_kerja_ikhtisar()
  {
    return $this->belongsTo('App\Repository\Pemeriksaan\KertasKerjaIkhtisar', 'id_kertas_kerja_ikhtisar')->where('adt_audit_kertas_kerja_ikhtisar.is_deleted', 0);
  }

}
