<?php

namespace App\Http\Controllers\Mst;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\Master\KodeTemuan;
use App\Service\Master\KodeTemuanService;

date_default_timezone_set('Asia/Jakarta');

class KodeTemuanController extends Controller
{

    public function get_kode_temuan_by_level(Request $request)
    {
      $data = KodeTemuan::where('level', $request->input('level'))
      ->select('id','temuan','kode')
      ->where('is_deleted', 0)
      ->where('id_parent', $request->input('parent'))->get();

      // get last update
      $last_update = KodeTemuanService::get_last_update();

      return response()->json(['data' => $data, 'last_update' => $last_update]);
    }

    
    public function check_last_update(Request $request)
    {
      // get last update
      $last_update = KodeTemuanService::get_last_update();

      return response()->json(['last_update' => $last_update]);
    }
}
