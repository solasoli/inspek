<?php

namespace App\Repository\Pegawai;

use App\Repository\BaseModel;
class Jabatan extends BaseModel
{
  protected $table = "pgw_jabatan";
  
  public function peran()
  {
    return $this->belongsToMany('App\Repository\Pegawai\Peran', 'pgw_peran_jabatan', 'id_jabatan', 'id_peran')
    ->using('App\Repository\Pegawai\PeranJabatan')
    ->wherePivot('is_deleted',0);
  }

}
