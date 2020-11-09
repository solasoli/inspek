<?php

namespace App\Repository\ACL;

use App\Repository\BaseModel;

class Role extends BaseModel
{
  protected $table = "acl_role";
  protected $primaryKey = "id";
  public $timestamps = false;
}
