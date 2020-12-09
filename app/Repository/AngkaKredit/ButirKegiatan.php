<?php

namespace App\Repository\AngkaKredit;

use App\Repository\BaseModel;
use Illuminate\Database\Eloquent\Model;

class ButirKegiatan extends Model
{
  protected $table = "akr_butir_kegiatan";
  public $timestamps = false;

  
  public function satuan()
  {
    return $this->belongsTo('App\Repository\AngkaKredit\ButirKegiatanSatuan', 'id_butir_kegiatan_satuan');
  }
  
}
