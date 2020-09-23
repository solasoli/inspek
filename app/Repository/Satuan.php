<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Satuan extends Model
{
  protected $table = "mst_satuan";
  protected $primaryKey = "id";
  protected $fillable = ["nama"];
  public $timestamps = false;
}
