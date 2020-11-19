<?php

namespace App\Repository\Pemeriksaan;

use App\Repository\BaseModel;
use Illuminate\Database\Eloquent\Model;

class LangkahKerjaPemeriksaanProsedurPelaksana extends BaseModel
{
  protected $table = "sp_langkah_kerja_pemeriksaan_prosedur_pelaksana";
  protected $fillable = [
    'id_prosedur',
    'id_pelaksana_rencana',
    'durasi_rencana',
    'id_pelaksana_realisasi',
    'durasi_realisasi'
    ];
}
