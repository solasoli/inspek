<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConfigDetail extends Model
{
  protected $table = "dev_config_detail";
  protected $primaryKey = "id";
  public $timestamps = false;
}
