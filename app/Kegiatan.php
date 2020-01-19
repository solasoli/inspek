<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
  protected $table = "renstra_kegiatan";
  protected $primaryKey = "id";
  protected $fillable = ['kode','label','id_program'];
  public $timestamps = false;
}
