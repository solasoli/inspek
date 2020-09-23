<?php

namespace App\Http\Controllers\Mst;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Datatables;
use Illuminate\Support\Facades\DB;
use App\Repository\Master\Skpd;
use App\Service\Master\SkpdService;
use App\Service\Master\WilayahService;

date_default_timezone_set('Asia/Jakarta');

class SkpdController extends Controller
{

  public function index()
  {
    $wilayah_kerja = WilayahService::get_wilayah();

    return view('Mst.skpd-list', [
      'wilayah_kerja' => $wilayah_kerja
    ]);
  }

  public function store(Request $request)
  {
    $validation_rules = SkpdService::get_validation();
    request()->validate($validation_rules->rules, $validation_rules->label);

    SkpdService::create($request->input());

    $request->session()->flash('success', "<strong>" . $request->input('name') . "</strong> Berhasil disimpan!");
    return redirect('/mst/skpd');
  }

  public function update(Request $request, $id)
  {
    $validation_rules = SkpdService::get_validation($id);
    request()->validate($validation_rules->rules, $validation_rules->label);

    SkpdService::update($id, $request->input());

    $request->session()->flash('success', "<strong>" . $request->input('name') . "</strong> berhasil diubah!");
    return redirect('/mst/skpd');
  }

  public function destroy(Request $request, $id)
  {
    SkpdService::delete($id);

    $request->session()->flash('success', "Data berhasil Dihapus!");
    return redirect('/mst/skpd');
  }

  public function list_datatables_api()
  {
    $data = Skpd::with('wilayah');

    return Datatables::eloquent($data)->toJson();
  }

  public function get_skpd_by_id(Request $request)
  {
    $id = $request->input('id');
    $data = DB::table('mst_skpd AS skpd')
      ->where('id', $id)
      ->where('is_deleted', 0)
      ->get()->first();

    return response()->json($data);
  }

  public function get_skpd_by_id_wilayah(Request $request)
  {
    $id_wilayah = $request->input('id') > 0 ? $request->input('id') : 0;
    $data = Skpd::where('id_wilayah', $id_wilayah)
      ->where('is_deleted', 0)
      ->orderBy('id', 'ASC')
      ->get();

    return response()->json($data);
  }
}
