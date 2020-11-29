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

  public function kertas_kerja_ikhtisar()
  {
    return $this->hasMany('App\Repository\Pemeriksaan\KertasKerjaIkhtisar', 'id_kertas_kerja');
  }

  public function audit_berkas()
  {
    return $this->hasMany('App\Repository\Pemeriksaan\AuditBerkas', 'id_kertas_kerja')->where("adt_audit_berkas.is_deleted", 0);
  }

  public function review()
  {
    return $this->hasMany('App\Repository\Pemeriksaan\KertasKerjaReview', 'id_kertas_kerja')->where("adt_audit_kertas_kerja_review.is_deleted" , 0);
  }

  public function oleh()
  {
    return $this->belongsTo('App\User', 'created_by');
  }
  
  public function status()
  {
    return $this->belongsTo('App\Repository\Pemeriksaan\KertasKerjaStatus', 'id_status_kertas_kerja');
  }
}
