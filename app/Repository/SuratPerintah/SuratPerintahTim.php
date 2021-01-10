<?php

namespace App\Repository\SuratPerintah;

use Illuminate\Database\Eloquent\Model;

class SuratPerintahTim extends Model
{
  protected $table = "pkpt_surat_perintah_tim";
  public $timestamps = false;

  
  public function skpd()
  {
    return $this->hasManyThrough('App\Repository\Master\Skpd','App\Repository\SuratPerintah\SuratPerintahSkpd', 'id_surat_perintah_tim', 'id', null, 'id_skpd')->where('pkpt_surat_perintah_skpd.is_deleted', 0);
  }
}
