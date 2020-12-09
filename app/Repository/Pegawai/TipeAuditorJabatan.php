<?php

namespace App\Repository\Pegawai;

use Illuminate\Database\Eloquent\Model;

class TipeAuditorJabatan extends Model
{
  protected $table = "pgw_tipe_auditor_jabatan";
  public $timestamps = false;

  
  public function tipe_auditor()
  {
    return $this->belongsTo('App\Repository\Pegawai\TipeAuditor', 'id_tipe_auditor');
  }
  
  public function jabatan()
  {
    return $this->belongsTo('App\Repository\Pegawai\Jabatan', 'id_jabatan');
  }
}