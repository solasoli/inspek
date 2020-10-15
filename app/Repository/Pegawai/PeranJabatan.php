<?php

namespace App\Repository\Pegawai;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PeranJabatan extends Pivot
{
  protected $table = "pgw_peran_jabatan";
  public $timestamps = false;
}
