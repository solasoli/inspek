<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RKAIndikatorKinerja extends Model
{
  protected $table = "rka_indikator_kinerja";
  protected $primaryKey = "id";
  public $timestamps = false;

  public function detail(){
  	return $this->hasMany("App\RKAIndikatorKinerjaDetail", "id_indikator_kinerja");
  }
}
