<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organisasi extends Model
{
  protected $table = "mst_organisasi";
  protected $primaryKey = "id";
  protected $fillable = ['kode','label','id_urusan_pemerintahan'];
  public $timestamps = false;
}
