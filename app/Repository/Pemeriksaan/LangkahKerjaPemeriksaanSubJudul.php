<?php

namespace App\Repository\Pemeriksaan;

use App\Repository\BaseModel;
use Illuminate\Database\Eloquent\Model;

class LangkahKerjaPemeriksaanSubJudul extends BaseModel
{
  protected $table = "sp_langkah_kerja_pemeriksaan_sub_judul";
  protected $fillable = ['sub_judul'];
}
