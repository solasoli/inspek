<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RKA extends Model
{
  protected $table = "rka_rka";
  protected $primaryKey = "id";
  public $timestamps = false;

  public function urusan_pemerintahan(){
  	return $this->belongsTo("App\UrusanPemerintahan", "id_urusan_pemerintahan");
  }

  public function organisasi(){
  	return $this->belongsTo("App\Organisasi", "id_organisasi");
  }

  public function program(){
  	return $this->belongsTo("App\Program", "id_program");
  }

  public function kegiatan(){
  	return $this->belongsTo("App\Kegiatan", "id_kegiatan");
  }

  public function indikator_kinerja(){
  	return $this->hasMany("App\RKAIndikatorKinerja", "id_rka");
  }

  public function indikator_kinerja_detail(){
  	return $this->hasManyThrough("App\RKAIndikatorKinerjaDetail","App\RKAIndikatorKinerja","id_rka","id_indikator_kinerja");
  }

  public function rincian_anggaran(){
  	return $this->hasMany("App\RKARincianAnggaran", "id_rka");
  }


  public function rincian_anggaran_detail(){
  	return $this->hasManyThrough("App\RKARincianAnggaranDetail","App\RKARincianAnggaran","id_rka","id_rincian_anggaran");
  }
}
