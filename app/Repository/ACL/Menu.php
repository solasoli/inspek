<?php

namespace App\Repository\ACL;

use App\Repository\BaseModel;

class Menu extends BaseModel
{
  protected $table = "acl_menu";
  protected $primaryKey = "id";
  public $timestamps = false;
}
