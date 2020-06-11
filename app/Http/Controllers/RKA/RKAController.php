<?php

namespace App\Http\Controllers\RKA;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Datatables;
use Validator;
use Auth;
use Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Input;
use App\RKA;

date_default_timezone_set('Asia/Jakarta');

class RKAController extends Controller
{

    public function index(){
      return view("rka.rka-list");
    }

    public function detail(Request $request, $id)
    {
      $rka = RKA::findOrFail($id);
      return view('rka.rka-detail',[
        'data' => $rka
      ]);
    }

    public function list_datatables_api()
    {
      $data = DB::table("rka_rka AS rka")
      ->select(DB::raw("up.label AS up_label, o.label AS o_label, p.label AS p_label, k.label AS k_label, rka.id"))
      ->join("mst_urusan_pemerintahan AS up", "up.id", "=", "rka.id_urusan_pemerintahan")
      ->join("mst_organisasi AS o", "o.id", "=", "rka.id_organisasi")
      ->join("rka_program AS p", "p.id", "=", "rka.id_program")
      ->join("rka_kegiatan AS k","k.id", "=", "rka.id_kegiatan")
      ->where("rka.is_deleted", 0)
      ->where("up.is_deleted", 0)
      ->where("o.is_deleted", 0)
      ->where("p.is_deleted", 0)
      ->where("k.is_deleted", 0);
      return Datatables::of($data)->make(true);
    }
}
