<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UrusanPemerintahan extends Model
{
  protected $table = "mst_urusan_pemerintahan";
  protected $primaryKey = "id";
  protected $fillable = ['kode','label'];
  public $timestamps = false;
}
