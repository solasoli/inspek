<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KodeRekening extends Model
{
  protected $table = "mst_kode_rekening";
  protected $primaryKey = "id";
  public $timestamps = false;
}
