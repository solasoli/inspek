<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
  protected $table = "acl_menu";
  protected $primaryKey = "id";
  public $timestamps = false;
}
