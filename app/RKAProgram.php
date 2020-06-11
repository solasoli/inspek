<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RKAProgram extends Model
{
  protected $table = "rka_program";
  protected $primaryKey = "id";
  protected $fillable = ['kode','label','id_organisasi'];
  public $timestamps = false;
}
