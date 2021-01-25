<?php

namespace App\Repository\SuratPerintah;

use App\Repository\BaseModel;

class SuratPerintah extends BaseModel
{
  protected $table = "pkpt_surat_perintah";

  public function wilayah()
  {
    return $this->hasManyThrough('App\Repository\Master\Wilayah','App\Repository\SuratPerintah\SuratPerintahWilayah', 'id_surat_perintah', 'id', null, 'id_wilayah')->where('pkpt_surat_perintah_wilayah.is_deleted', 0);
  }

  public function tim()
  {
    return $this->hasMany('App\Repository\SuratPerintah\SuratPerintahTim', 'id_surat_perintah')->where('pkpt_surat_perintah_tim.is_deleted', 0);
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

  public function jabatan()
  {
    return $this->belongsTo('App\Repository\Pegawai\Pegawai', 'id_jabatan');
  }

  // public function pangkat()
  // {
  //   return $this->belongsTo('App\Repository\Pegawai\Pegawai', 'id_jabatan');
  // }

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

  
  public function anggota_tim()
  {
    return $this->hasMany('App\Repository\SuratPerintah\SuratPerintahAnggota', 'id_surat_perintah', 'id')
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
  
  public function program_kerja_audit_review()
  {
    return $this->hasMany('App\Repository\Pemeriksaan\ProgramKerjaAuditReview', 'id_surat_perintah');
  }

  public function langkah_kerja_pemeriksaan()
  {
    return $this->hasMany('App\Repository\Pemeriksaan\LangkahKerjaPemeriksaan', 'id_surat_perintah');
  }
  
  public function audit_kertas_kerja()
  {
    return $this->hasMany('App\Repository\Pemeriksaan\KertasKerja', 'id_surat_perintah');
  }
  
  public function status()
  {
    return $this->belongsTo('App\Repository\SuratPerintah\SuratPerintahStatus', 'id_status_sp');
  }

  public function tindak_lanjut_review()
  {
    return $this->hasOne('App\Repository\SuratPerintah\SuratPerintahTindakLanjutReview', 'id_surat_perintah')->where('pkpt_surat_perintah_tindak_lanjut_review.is_deleted', 0);
  }
}
