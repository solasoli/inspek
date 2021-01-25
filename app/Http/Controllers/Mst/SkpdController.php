<?php

namespace App\Http\Controllers\Mst;

use App\Export\SkpdExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Datatables;
use Illuminate\Support\Facades\DB;
use App\Repository\Master\Skpd;
use App\Service\Master\SkpdService;
use App\Service\Master\WilayahService;
use App\Http\Requests\Master\SkpdRequest;
use App\Repository\Master\ProgramKerja;
use Maatwebsite\Excel\Facades\Excel;

date_default_timezone_set('Asia/Jakarta');

class SkpdController extends Controller
{

  public function index()
  {
    $wilayah_kerja = WilayahService::get_data();

    return view('Mst.skpd-list', [
      'wilayah_kerja' => $wilayah_kerja
    ]);
  }

  public function store(SkpdRequest $request)
  {
    SkpdService::create($request->input());
    $request->session()->flash('success', "Data berhasil disimpan!");
    return response()->json(['success' => true]);
  }

  public function update(SkpdRequest $request, $id)
  {
    SkpdService::update($id, $request->input());
    $request->session()->flash('success', "Data berhasil disimpan!");
    return response()->json(['success' => true]);
  }

  public function destroy(Request $request, $id)
  {
    SkpdService::delete($id);

    $request->session()->flash('success', "Data berhasil Dihapus!");
    return redirect('/mst/skpd');
  }

  public function list_datatables_api()
  {
    $data = Skpd::with('wilayah')->where('is_deleted', 0);

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

  public function get_all_skpd(Request $request)
  {
    $id = $request->input('id');
    $data = DB::table('mst_skpd AS skpd')
      ->where('is_deleted', 0)
      ->get();

    return response()->json($data);
  }

  public function get_skpd_by_id_wilayah(Request $request)
  {
    $id_wilayah = $request->input('id') > 0 ? $request->input('id') : 0;
    $data = Skpd::where('is_deleted', 0)
      ->orderBy('id', 'ASC');

    if($request->input('id') != 'all') {
      $data->where('id_wilayah', $id_wilayah);
    }

    $data = $data->get();

    return response()->json($data);
  }

  public function get_skpd_by_multiple_wilayah(Request $request)
  {

    $id_wilayah = $request->input('id_wilayah');
    $data = Skpd::whereIn('id_wilayah', $id_wilayah)
      ->where('is_deleted', 0)
      ->orderBy('id', 'ASC')
      ->get();

    return response()->json($data);
  }

  public function get_skpd_by_program_kerja(Request $request)
  {

    $id_program_kerja = $request->input('id_program_kerja');
    $data = ProgramKerja::find($id_program_kerja);
    $data = !is_null($data) ? $data->skpd : [];

    return response()->json(['data' => $data]);
  }

  public function print($method = 'html')
  {
    if($method == 'html') {
      $data = Skpd::with('wilayah')->where('is_deleted', 0)->get();
      return view('Mst.skpd-print', [
        'data' => $data
      ]);
    } else if($method == 'excel') {
      return Excel::download(new SkpdExport, 'Perangkat Daerah.xlsx');
    }
  }
}
