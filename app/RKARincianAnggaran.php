<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RKARincianAnggaran extends Model
{
  protected $table = "rka_rincian_anggaran";
  protected $primaryKey = "id";
  public $timestamps = false;

  public function kode_rekening(){
  	return $this->belongsTo("App\KodeRekening", "id_kode_rekening");
  }
}
