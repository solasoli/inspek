<?php

namespace App\Repository\Master;

use App\Repository\BaseModel;
use Illuminate\Database\Eloquent\Model;

class ProgramKerjaAudit extends BaseModel
{
  protected $table = "mst_program_kerja_audit";
  public $timestamps = false;
}
