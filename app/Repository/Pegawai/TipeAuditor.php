<?php

namespace App\Repository\Pegawai;

use Illuminate\Database\Eloquent\Model;

class TipeAuditor extends Model
{
  protected $table = "pgw_tipe_auditor";
  public $timestamps = false;

  
  public function tipe_auditor_jabatan()
  {
    return $this->hasMany('App\Repository\Pegawai\TipeAuditorJabatan', 'id_tipe_auditor');
  }

}