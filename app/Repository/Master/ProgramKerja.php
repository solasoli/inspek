<?php

namespace App\Repository\Master;

use App\Repository\BaseModel;

class ProgramKerja extends BaseModel
{
  protected $table = "mst_program_kerja";
  public $timestamps = false;

  public function skpd()
  {
    return $this->belongsTo('App\Repository\Master\Skpd', 'id_skpd');
  }

  public function kegiatan()
  {
    return $this->belongsTo('App\Repository\Master\Kegiatan', 'id_kegiatan');
  }

  public function wilayah()
  {
    return $this->belongsTo('App\Repository\Master\Wilayah', 'id_wilayah');
  }

}
