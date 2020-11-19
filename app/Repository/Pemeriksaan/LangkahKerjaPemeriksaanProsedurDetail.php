<?php

namespace App\Repository\Pemeriksaan;

use App\Repository\BaseModel;
use Illuminate\Database\Eloquent\Model;

class LangkahKerjaPemeriksaanProsedurDetail extends BaseModel
{
  protected $table = "sp_langkah_kerja_pemeriksaan_prosedur_detail";
  protected $fillable = ['prosedur_detail'];
}
