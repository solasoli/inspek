<?php
namespace App\Http\Controllers\Mst;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Datatables;
use Auth;
use App\Service\Master\WilayahService;
use App\Service\Pegawai\PegawaiService;

date_default_timezone_set('Asia/Jakarta');

class StrukturController extends Controller
{
    public function index()
    {
      $wilayah = WilayahService::get_data();

      return view('Mst.struktur-list', [
        'wilayah' => $wilayah,
      ]);
    }

    public function update(Request $request, $id)
    {
      PegawaiService::change_atasan_langsung($id, $request->input('atasan_langsung'));

      // $request->session()->flash('success', "Data berhasil diubah!");
      return response()->json(['state' => 'success', 'msg' => 'Data berhasil diubah!']);
      // return redirect('/mst/struktur');
    }

    public function list_datatables_api()
    {
      $data = PegawaiService::get_anggota_sort_by_jabatan(true);

      return Datatables::eloquent($data)->toJson();
    }

}
