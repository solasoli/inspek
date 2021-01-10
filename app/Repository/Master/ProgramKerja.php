<?php

namespace App\Repository\Master;

use App\Repository\BaseModel;

class ProgramKerja extends BaseModel
{
  protected $table = "mst_program_kerja";
  public $timestamps = false;

  public function skpd()
  {
    return $this->hasManyThrough('App\Repository\Master\Skpd','App\Repository\Master\ProgramKerjaSkpd', 'id_program_kerja', 'id', null, 'id_skpd')->where('mst_program_kerja_skpd.is_deleted', 0);
  }

  public function kegiatan()
  {
    return $this->belongsTo('App\Repository\Master\Kegiatan', 'id_kegiatan');
  }

  public function jenis_pengawasan()
  {
    return $this->hasManyThrough('App\Repository\Master\JenisPengawasan','App\Repository\Master\ProgramKerjaJenisPengawasan', 'id_program_kerja', 'id', null, 'id_jenis_pengawasan')->where('mst_program_kerja_jenis_pengawasan.is_deleted', 0);
  }

  public function wilayah()
  {
    return $this->hasManyThrough('App\Repository\Master\Wilayah','App\Repository\Master\ProgramKerjaWilayah', 'id_program_kerja', 'id', null, 'id_wilayah')->where('mst_program_kerja_wilayah.is_deleted', 0);
  }

}
