<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RKAKegiatan extends Model
{
  protected $table = "rka_kegiatan";
  protected $fillable = ['kode','id_program','label'];
}
