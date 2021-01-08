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

use App\Repository\Master\JenisPengawasan;
use App\Service\Master\JenisPengawasanService;
use App\Http\Requests\Master\JenisPengawasanRequest;

date_default_timezone_set('Asia/Jakarta');

class JenisPengawasanController extends Controller
{


  public function index()
  {
    return view('Mst.jenis_pengawasan-list');
  }


  public function store(JenisPengawasanRequest $request)
  {
    JenisPengawasanService::create($request->input());
    $request->session()->flash('success', "Data berhasil disimpan!");
    return response()->json(['success' => true]);
  }

  public function update(JenisPengawasanRequest $request, $id)
  {
    JenisPengawasanService::update($id, $request->input());
    $request->session()->flash('success', "Data berhasil disimpan!");
    return response()->json(['success' => true]);
  }

  public function destroy(Request $request, $id)
  {
    JenisPengawasanService::delete($id);

    $request->session()->flash('success', "Data berhasil Dihapus!");
    return redirect('/mst/jenis_pengawasan');
  }

  public function list_datatables_api()
  {
    $data = JenisPengawasan::where('is_deleted', 0);
    return Datatables::eloquent($data)->toJson();
  }

  public function get_jenis_pengawasan(JenisPengawasanRequest $request)
  {
    $data = JenisPengawasan::where('is_deleted', 0)
      ->orderBy('id', 'ASC')
      ->get();

    return response()->json($data);
  }

  public function get_jenis_pengawasan_by_id(Request $request)
  {
    $id = $request->input('id');
    $data = JenisPengawasan::where("is_deleted", 0)->where("id", $id)->first();

    return response()->json($data);
  }
}
