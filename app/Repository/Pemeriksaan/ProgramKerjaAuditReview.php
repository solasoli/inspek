<?php

namespace App\Repository\Pemeriksaan;

use Illuminate\Database\Eloquent\Model;

class ProgramKerjaAuditReview extends Model
{
  protected $table = "sp_program_kerja_audit_review";
  protected $fillable = ['id_surat_perintah','id_program_kerja_audit'];

  public function surat_perintah()
  {
    return $this->belongsTo('App\Repository\SuratPerintah\SuratPerintah', 'id_surat_perintah')->where('pkpt_surat_perintah.is_deleted', 0);
  }

}
