<?php

namespace App\Repository\Pemeriksaan;

use App\Repository\BaseModel;

class KertasKerjaIkhtisar extends BaseModel
{
  protected $table = "adt_audit_kertas_kerja_ikhtisar";
  protected $fillable = [
      'id_surat_perintah',
      'judul_kondisi',
      'uraian_kondisi',
      'kriteria',
      'sebab',
      'akibat',
      'rekomendasi'
    ];

  public function surat_perintah()
  {
    return $this->belongsTo('App\Repository\SuratPerintah\SuratPerintah', 'id_surat_perintah')->where('pkpt_surat_perintah.is_deleted', 0);
  }
  
  public function kode_temuan()
  {
    return $this->hasMany('App\Repository\Pemeriksaan\KertasKerjaIkhtisarKodeTemuan', 'id_kertas_kerja_ikhtisar');
  }
  
  public function kode_rekomendasi()
  {
    return $this->hasMany('App\Repository\Pemeriksaan\KertasKerjaIkhtisarKodeRekomendasi', 'id_kertas_kerja_ikhtisar');
  }
}
