<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TempKodeRekening extends Model
{
  protected $table = "temp_kode_rekening";
  protected $primaryKey = "id";
  public $timestamps = false;
}
