<?php

namespace App\Repository\SuratPerintah;

use Illuminate\Database\Eloquent\Model;

class SuratPerintahAnggota extends Model
{
  protected $table = "pkpt_surat_perintah_anggota";
  public $timestamps = false;

  
  public function anggota()
  {
    return $this->belongsTo('App\Repository\Pegawai\Pegawai', 'id_anggota');
  }
}
