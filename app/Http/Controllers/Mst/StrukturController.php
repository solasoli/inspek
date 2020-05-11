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
use App\Model\Pegawai\Pegawai;
use App\Wilayah;
use App\Model\Pegawai\PeranJabatan;
use App\Service\PegawaiService;

date_default_timezone_set('Asia/Jakarta');

class StrukturController extends Controller
{
    public function index()
    {
      $wilayah = Wilayah::where("is_deleted", 0)->orderBy('id')->get();

      return view('Mst.struktur-list', [
        'wilayah' => $wilayah,
      ]);
    }

    public function create()
    {

    }

    public function store(Request $request)
    {

    }

    public function edit($id)
    {

    }

    public function update(Request $request, $id)
    {
      $logged_user = Auth::user();

      $t = Pegawai::findOrFail($id);
      $t->atasan_langsung = $request->input('atasan_langsung');
      $t->save();

      $request->session()->flash('success', "Data berhasil diubah!");
      return redirect('/mst/struktur');
    }

    public function destroy(Request $request, $id)
    {

    }

    public function list_datatables_api()
    {
      $data = PegawaiService::get_anggota(true);
      return Datatables::of($data)->make(true);
    }

}
