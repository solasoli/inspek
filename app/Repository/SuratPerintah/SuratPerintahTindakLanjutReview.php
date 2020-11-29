<?php

namespace App\Repository\SuratPerintah;

use App\Repository\BaseModel;

class SuratPerintahTindakLanjutReview extends BaseModel
{
  protected $table = "pkpt_surat_perintah_tindak_lanjut_review";

  public function surat_perintah()
  {
    return $this->belongsTo('App\Repository\SuratPerintah\SuratPerintah', 'id_surat_perintah');
  }

}
