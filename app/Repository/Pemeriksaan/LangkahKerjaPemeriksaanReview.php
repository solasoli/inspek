<?php

namespace App\Repository\Pemeriksaan;

use Illuminate\Database\Eloquent\Model;

class LangkahKerjaPemeriksaanReview extends Model
{
  protected $table = "sp_langkah_kerja_pemeriksaan_review";

  public function langkah_kerja_pemeriksaan()
  {
    return $this->belongsTo('App\Repository\Pemeriksaan\LangkahKerjaPemeriksaan', 'id_langkah_kerja_pemeriksaan');
  }

}
