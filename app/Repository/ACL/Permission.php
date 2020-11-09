<?php

namespace App\Repository\ACL;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
  protected $table = "acl_permission";
  protected $primaryKey = "id";
  public $timestamps = false;
}
