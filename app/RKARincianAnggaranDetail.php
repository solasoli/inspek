<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RKARincianAnggaranDetail extends Model
{
  protected $table = "rka_rincian_anggaran_detail";
  protected $primaryKey = "id";
  public $timestamps = false;

  public function satuan(){
  	return $this->belongsTo("App\Satuan", "id_satuan");
  }
}
