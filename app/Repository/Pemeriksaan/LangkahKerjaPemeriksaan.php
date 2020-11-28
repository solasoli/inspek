<?php

namespace App\Repository\Pemeriksaan;

use App\Repository\BaseModel;
use Illuminate\Database\Eloquent\Model;

class LangkahKerjaPemeriksaan extends BaseModel
{
  protected $table = "sp_langkah_kerja_pemeriksaan";
  protected $fillable = ['judul_tugas',
  'sub_judul_tugas',
  'prosedur_pemeriksaan',
  'tujuan_pemeriksaan',
  'id_pelaksana_rencana',
  'durasi_rencana',
  'id_pelaksana_realisasi',
  'durasi_realisasi'
];

  public function pelaksana_rencana()
  {
    return $this->belongsTo('App\Repository\Pegawai\Pegawai', 'id_pelaksana_rencana')->where('pkpt_surat_perintah.is_deleted', 0);
  }

  public function pelaksana_realisasi()
  {
    return $this->belongsTo('App\Repository\Pegawai\Pegawai', 'id_pelaksana_realisasi')->where('pkpt_surat_perintah.is_deleted', 0);
  }

  public function surat_perintah()
  {
    return $this->belongsTo('App\Repository\SuratPerintah\SuratPerintah', 'id_surat_perintah')->where('pkpt_surat_perintah.is_deleted', 0);
  }

  public function sub_judul()
  {
    return $this->hasMany('App\Repository\Pemeriksaan\LangkahKerjaPemeriksaanSubJudul', 'id_lkp')->where('sp_langkah_kerja_pemeriksaan_sub_judul.is_deleted', 0);
  }
  
  public function prosedur()
  {
    return $this->hasMany('App\Repository\Pemeriksaan\LangkahKerjaPemeriksaanProsedur', 'id_lkp')->where('sp_langkah_kerja_pemeriksaan_prosedur.is_deleted', 0);
  }

  public function review()
  {
    return $this->hasOne('App\Repository\Pemeriksaan\LangkahKerjaPemeriksaanReview', 'id_langkah_kerja_pemeriksaan');
  }
}
