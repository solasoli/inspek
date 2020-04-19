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

date_default_timezone_set('Asia/Jakarta');

class StrukturController extends Controller
{
    public function index()
    {
      $wilayah = Wilayah::where("is_deleted", 0)->orderBy('id')->get();

      return view('mst.struktur-list', [
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
      $data = DB::table("pgw_pegawai AS p")
      ->select(DB::raw("p.id, p.nama, p.id_jabatan, j.name AS jabatan, p.atasan_langsung"))
      ->join("pgw_jabatan AS j", "p.id_jabatan", "=", "j.id")
      ->join("pgw_eselon AS e", "p.id_eselon", "=", "e.id")
      ->join("pgw_peran_jabatan AS ppj", "ppj.id_jabatan", "=","p.id_jabatan")
      ->join("pgw_peran AS pp", "pp.id", "=","ppj.id_peran")
      ->whereRaw(DB::raw("e.level >= 3"))
      ->where('p.is_deleted', 0)
      ->whereRaw(DB::raw("pp.kode NOT IN ('sekretaris','wakil_sekretaris')"))
      ->where('j.is_deleted', 0);
      return Datatables::of($data)->make(true);
    }

}
