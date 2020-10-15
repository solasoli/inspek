<?php

namespace App\Repository\Pegawai;

use App\Repository\BaseModel;

class Peran extends BaseModel
{
  protected $table = "pgw_peran";

  public function jabatan()
  {
    return $this->hasManyThrough('App\Repository\Pegawai\Jabatan', 'App\Repository\Pegawai\PeranJabatan', 'id_peran', 'id', null, 'id_jabatan');
  }
}
