<?php

namespace App\Repository\Pemeriksaan;

use App\Repository\BaseModel;
use Illuminate\Database\Eloquent\Model;

class LangkahKerjaPemeriksaanUraian extends BaseModel
{
  protected $table = "sp_langkah_kerja_pemeriksaan_uraian";
  protected $fillable = ['uraian'];

  public function uraian_detail()
  {
    return $this->hasMany('App\Repository\Pemeriksaan\LangkahKerjaPemeriksaanUraianDetail', 'id_uraian');
  }
}
