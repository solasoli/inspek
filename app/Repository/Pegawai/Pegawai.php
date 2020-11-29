<?php

namespace App\Repository\Pegawai;

use App\Repository\BaseModel;

class Pegawai extends BaseModel
{
  protected $table = "pgw_pegawai";

  public function pangkat_golongan()
  {
    return $this->belongsTo('App\Repository\Pegawai\PangkatGolongan', 'id_pangkat_golongan');
  }

  public function user_pegawai()
  {
    return $this->hasOne('App\Repository\Pegawai\UserPegawai', 'id_pegawai');
  }

  public function pangkat()
  {
    return $this->belongsTo('App\Repository\Pegawai\Pangkat', 'id_pangkat');
  }

  public function jabatan()
  {
    return $this->belongsTo('App\Repository\Pegawai\Jabatan', 'id_jabatan');
  }

  public function eselon()
  {
    return $this->belongsTo('App\Repository\Pegawai\Eselon', 'id_eselon');
  }

  public function wilayah()
  {
    return $this->belongsTo('App\Repository\Master\Wilayah', 'id_wilayah');
  }

  public function peran()
  {
    return $this->belongsTo('App\Repository\Pegawai\Peran', 'id_peran');
  }
}
