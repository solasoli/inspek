<?php

namespace App\Repository\Master;

use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
  protected $table = "mst_periode";
  protected $primaryKey = "id";
  public $timestamps = false;
}
