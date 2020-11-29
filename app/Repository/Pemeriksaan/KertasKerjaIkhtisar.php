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

  public function kertas_kerja()
  {
    return $this->belongsTo('App\Repository\Pemeriksaan\KertasKerja', 'id_kertas_kerja');
  }
  
  public function kode_temuan()
  {
    return $this->hasMany('App\Repository\Pemeriksaan\KertasKerjaIkhtisarKodeTemuan', 'id_kertas_kerja_ikhtisar');
  }
  
  public function kode_rekomendasi()
  {
    return $this->hasMany('App\Repository\Pemeriksaan\KertasKerjaIkhtisarKodeRekomendasi', 'id_kertas_kerja_ikhtisar');
  }

  public function review()
  {
    return $this->hasMany('App\Repository\Pemeriksaan\KertasKerjaIkhtisarReview', 'id_kertas_kerja_ikhtisar')->where("adt_audit_kertas_kerja_ikhtisar_review.is_deleted" , 0);
  }

  public function tindak_lanjut()
  {
    return $this->hasOne('App\Repository\Pemeriksaan\KertasKerjaIkhtisarTindakLanjut', 'id_kertas_kerja_ikhtisar')->where("adt_audit_kertas_kerja_ikhtisar_tindak_lanjut.is_deleted" , 0);
  }

}
