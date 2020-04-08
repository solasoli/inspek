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
use App\Model\Pegawai\Peran;
use App\Model\Pegawai\PeranJabatan;

date_default_timezone_set('Asia/Jakarta');

class StrukturController extends Controller
{
    public function index()
    {
      $pegawai = Pegawai::select('id', 'nama')->where("is_deleted", 0)->orderBy('nama')->get();
      $wilayah = Wilayah::where("is_deleted", 0)->orderBy('id')->get();
      $peran = Peran::select('id', 'nama')->where("is_deleted", 0)->orderBy('id')->get();

      return view('mst.struktur-list', [
        'pegawai' => $pegawai,
        'wilayah' => $wilayah,
        'peran' => $peran,
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
      $t->id_wilayah = $request->input('id_wilayah');
      $t->id_peran = $request->input('id_peran');
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
      ->select(DB::raw("p.id, p.nama, p.id_jabatan, j.name AS jabatan, p.atasan_langsung, p.id_peran, p.id_wilayah"))
      ->join("pgw_jabatan AS j", "p.id_jabatan", "=", "j.id")
      ->where('p.is_deleted', 0)
      ->where('j.is_deleted', 0);
      return Datatables::of($data)->make(true);
    }

}
