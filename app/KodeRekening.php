<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KodeRekening extends Model
{
  protected $table = "mst_kode_rekening";
  protected $fillable = ['kode_rekening','uraian','parent_id','level'];
  protected $primaryKey = "id";
  public $timestamps = false;
}
