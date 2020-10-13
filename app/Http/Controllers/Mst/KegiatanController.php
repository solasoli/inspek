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

use App\Repository\Master\Skpd;
use App\Repository\Master\Kegiatan;
use App\Service\Master\SkpdService;
use App\Service\Master\KegiatanService;
use App\Http\Requests\Master\KegiatanRequest;

date_default_timezone_set('Asia/Jakarta');

class KegiatanController extends Controller
{


    public function index()
    {
      return view('Mst.kegiatan-list');
    }

    public function store(KegiatanRequest $request)
    {
      KegiatanService::create($request->input());
      $request->session()->flash('success', "Data berhasil disimpan!");
      return response()->json(['success' => true]);
    }

    public function update(KegiatanRequest $request, $id)
    {
      KegiatanService::update($id, $request->input());
      $request->session()->flash('success', "Data berhasil disimpan!");
      return response()->json(['success' => true]);
    }

    public function destroy(Request $request, $id)
    {
      KegiatanService::delete($id);

      $request->session()->flash('success', "Data berhasil Dihapus!");
      return redirect('/mst/kegiatan');
    }

    public function list_datatables_api()
    {
      $data = Kegiatan::where('is_deleted', 0);
      return Datatables::eloquent($data)->toJson();
    }

    public function get_kegiatan(Request $request)
    {
      $data = Kegiatan::where('is_deleted', 0)
      ->orderBy('id', 'ASC')
      ->get();

      return response()->json($data);
    }

    public function get_kegiatan_by_id(Request $request)
    {
      $id = $request->input('id');
      $data = Kegiatan::where("is_deleted", 0)->where("id", $id)->first();

      return response()->json($data);
    }
}
