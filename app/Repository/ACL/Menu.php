<?php

namespace App\Repository\ACL;

use App\Repository\BaseModel;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
  protected $table = "acl_menu";
  protected $primaryKey = "id";
  public $timestamps = false;
}
