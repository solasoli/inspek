<?php

namespace App\Http\Controllers\Mst;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Datatables;
use Validator;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Input;
use App\Wilayah;
use App\WilayahSkpd;
use App\WilayahAnggota;
use App\Skpd;
use App\Model\Pegawai\Pegawai;

date_default_timezone_set('Asia/Jakarta');

class KodeTemuanController extends Controller
{

    public function get_wilayah_by_id(Request $request)
    {
      $data = Wilayah::find($request->input('id'));

      return response()->json($data);
    }
}
