<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
  protected $table = "acl_role";
  protected $primaryKey = "id";
  public $timestamps = false;
}
