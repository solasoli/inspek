<?php

namespace App\Repository\AngkaKredit;

use App\Repository\BaseModel;
use Illuminate\Database\Eloquent\Model;

class SubUnsur extends Model
{
  protected $table = "akr_sub_unsur";
  public $timestamps = false;

  
  public function butir_kegiatan()
  {
    return $this->hasMany('App\Repository\AngkaKredit\ButirKegiatan', 'id_sub_unsur');
  }
  
}
