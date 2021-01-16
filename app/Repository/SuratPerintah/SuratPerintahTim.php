<?php

namespace App\Repository\SuratPerintah;

use App\Repository\BaseModel;
use Illuminate\Database\Eloquent\Model;

class SuratPerintahTim extends BaseModel
{
  protected $table = "pkpt_surat_perintah_tim";
  public $timestamps = false;

  
  public function skpd()
  {
    return $this->hasManyThrough('App\Repository\Master\Skpd','App\Repository\SuratPerintah\SuratPerintahSkpd', 'id_surat_perintah_tim', 'id', null, 'id_skpd')->where('pkpt_surat_perintah_skpd.is_deleted', 0);
  }
  
  public function inspektur_pembantu()
  {
    return $this->belongsTo('App\Repository\Pegawai\Pegawai', 'id_inspektur_pembantu');
  }
  
  public function pengendali_teknis()
  {
    return $this->belongsTo('App\Repository\Pegawai\Pegawai', 'id_pengendali_teknis');
  }

  public function ketua_tim()
  {
    return $this->belongsTo('App\Repository\Pegawai\Pegawai', 'id_ketua_tim');
  }

}
