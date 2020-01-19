<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
  protected $table = "renstra_program";
  protected $primaryKey = "id";
  protected $fillable = ['kode','label','id_organisasi'];
  public $timestamps = false;
}
