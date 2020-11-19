<?php

namespace App\Repository\Pemeriksaan;

use App\Repository\BaseModel;
use Illuminate\Database\Eloquent\Model;

class LangkahKerjaPemeriksaanProsedur extends BaseModel
{
  protected $table = "sp_langkah_kerja_pemeriksaan_prosedur";
  protected $fillable = ['prosedur'];

  public function prosedur_detail()
  {
    return $this->hasMany('App\Repository\Pemeriksaan\LangkahKerjaPemeriksaanProsedurDetail', 'id_prosedur');
  }

  public function prosedur_pelaksana()
  {
    return $this->hasOne('App\Repository\Pemeriksaan\LangkahKerjaPemeriksaanProsedurPelaksana', 'id_prosedur');
  }
}
