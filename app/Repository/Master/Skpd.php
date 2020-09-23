<?php

namespace App\Repository\Master;

use App\Repository\BaseModel;

class Skpd extends BaseModel
{
  protected $table = "mst_skpd";

  public function wilayah()
  {
    return $this->belongsTo('App\Repository\Master\Wilayah','id_wilayah');
  }
}
