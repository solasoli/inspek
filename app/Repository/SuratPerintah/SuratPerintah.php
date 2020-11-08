<?php

namespace App\Repository\SuratPerintah;

use Illuminate\Database\Eloquent\Model;

class SuratPerintah extends Model
{
  protected $table = "pkpt_surat_perintah";

  public function wilayah()
  {
    return $this->belongsTo('App\Repository\Master\Wilayah', 'id_wilayah');
  }

  public function inspektur()
  {
    return $this->belongsTo('App\Repository\Pegawai\Pegawai', 'id_inspektur');
  }

  public function inspektur_pembantu()
  {
    return $this->belongsTo('App\Repository\Pegawai\Pegawai', 'id_inspektur_pembantu');
  }

  public function pengendali_teknis()
  {
    return $this->belongsTo('App\Repository\Pegawai\Pegawai', 'id_pengendali_teknis');
  }

  public function ketua_tim()
  {
    return $this->belongsTo('App\Repository\Pegawai\Pegawai', 'id_ketua_tim');
  }

  public function program_kerja()
  {
    return $this->belongsTo('App\Repository\Master\ProgramKerja', 'id_program_kerja');
  }

  public function kegiatan()
  {
    return $this->belongsTo('App\Repository\Master\Kegiatan', 'id_kegiatan');
  }

  public function anggota()
  {
    return $this->hasManyThrough('App\Repository\Pegawai\Pegawai', 'App\Repository\SuratPerintah\SuratPerintahAnggota', 'id_surat_perintah', 'id', null, 'id_anggota')
    ->where('pkpt_surat_perintah_anggota.is_deleted',0);
  }

  public function sasaran()
  {
    return $this->hasManyThrough('App\Repository\Master\Sasaran', 'App\Repository\SuratPerintah\SuratPerintahSasaran', 'id_surat_perintah', 'id', null, 'id_sasaran')
    ->where('pkpt_surat_perintah_sasaran.is_deleted',0);
  }

  public function penentuan_sasaran_tujuan()
  {
    return $this->hasMany('App\Repository\Pemeriksaan\PenentuanSasaranTujuan', 'id_surat_perintah')->where('sp_penentuan_sasaran_tujuan.is_deleted', 0);
  }

  public function program_kerja_audit()
  {
    return $this->hasMany('App\Repository\Pemeriksaan\ProgramKerjaAudit', 'id_surat_perintah');
  }
  
  public function langkah_kerja_pemeriksaan()
  {
    return $this->hasMany('App\Repository\Pemeriksaan\LangkahKerjaPemeriksaan', 'id_surat_perintah');
  }

}
