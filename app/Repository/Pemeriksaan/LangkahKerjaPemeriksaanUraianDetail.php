<?php

namespace App\Repository\Pemeriksaan;

use App\Repository\BaseModel;
use Illuminate\Database\Eloquent\Model;

class LangkahKerjaPemeriksaanUraianDetail extends BaseModel
{
  protected $table = "sp_langkah_kerja_pemeriksaan_uraian_detail";
  protected $fillable = ['uraian_detail'];
}
