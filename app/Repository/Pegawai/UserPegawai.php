<?php

namespace App\Repository\Pegawai;

use Illuminate\Database\Eloquent\Model;

class UserPegawai extends Model
{
  protected $table = "users_pegawai";
  public $timestamps = false;

  
  public function user()
  {
    return $this->belongsTo('App\User', 'id_user');
  }
  
  public function pegawai()
  {
    return $this->belongsTo('App\Repository\Pegawai\Pegawai', 'id_pegawai');
  }
}