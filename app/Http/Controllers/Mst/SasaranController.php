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
use App\Sasaran;
use App\Kegiatan;
use App\Skpd;
use App\Wilayah;
use App\Service\KegiatanService;

date_default_timezone_set('Asia/Jakarta');

class SasaranController extends Controller
{
    public function index()
    {
      $opd = Skpd::where("is_deleted", 0)->get();
      $wilayah = Wilayah::where("is_deleted", 0)->get();
      $kegiatan = Kegiatan::where("is_deleted", 0)->get();
      return view('Mst.sasaran-list', [
        'opd' => $opd,
        'kegiatan' => $kegiatan,
        'wilayah' => $wilayah,
      ]);
    }

    public function create()
    {
      $parent = Sasaran::where("is_deleted",0)->where("id_parent",0)->get();
      return view('Mst.sasaran-form',[
        'parent' => $parent
      ]);
    }

    public function store(Request $request)
    {
      $logged_user = Auth::user();
      request()->validate([
        'nama' => 'required',
        'wilayah' => 'required',
        'opd' => 'required',
        'dari' => 'required',
        'sampai' => 'required',
        'sasaran' => 'required',
      ],[
        'nama.required' => 'Nama Sasaran harus diisi!',
        'nama.unique' => 'Nama Sasaran sudah ada!',
        'wilayah.required' => 'Irban harus diisi!',
        'opd.required' => 'Perangkat Daerah harus diisi!',
        'dari.required' => 'Dari harus diisi!',
        'sampai.required' => 'Sampai harus diisi!',
      ]);


      KegiatanService::create($request->input());

      $request->session()->flash('success', "<strong>".$request->input('nama')."</strong> Berhasil disimpan!");
      return redirect('/mst/sasaran');
    }

    public function edit($id)
    {
      $data = Sasaran::find($id);

      $parent = Sasaran::where("is_deleted",0)->where("id_parent",0)->get();

      return view('Mst.sasaran-form', [
        'data' => $data,
        'parent' => $parent
      ]);
    }

    public function update(Request $request, $id)
    {
      $logged_user = Auth::user();
      request()->validate([
        'nama' => 'required',
        'wilayah' => 'required',
        'opd' => 'required',
        'dari' => 'required',
        'sampai' => 'required',
        'sasaran' => 'required',
      ],[
        'nama.required' => 'Nama Sasaran harus diisi!',
        'nama.unique' => 'Nama Sasaran sudah ada!',
        'wilayah.required' => 'Irban harus diisi!',
        'opd.required' => 'Perangkat Daerah harus diisi!',
        'dari.required' => 'Dari harus diisi!',
        'sampai.required' => 'Sampai harus diisi!',
      ]);

      KegiatanService::update($id, $request->input());

      $request->session()->flash('success', "Data berhasil diubah!");
      return redirect('/mst/sasaran');
    }

    public function destroy(Request $request, $id)
    {
      $logged_user = Auth::user();

      DB::transaction(function() use ($id) {
        $t = Kegiatan::findOrFail($id);
        $t->deleted_at = date('Y-m-d H:i:s');
        $t->deleted_by = Auth::id();
        $t->is_deleted = 1;
        $t->save();

        DB::table('mst_sasaran')
        ->where('id_kegiatan', $id)
        ->update(['is_deleted' => 1]);
      });

      $request->session()->flash('success', "Data berhasil Dihapus!");
      return redirect('/mst/sasaran');
    }

    public function list_datatables_api()
    {
      $data = DB::table("mst_kegiatan AS k")
      ->select(DB::raw("k.id, k.nama AS kegiatan, w.nama AS wilayah, skpd.name AS skpd, k.dari, k.sampai, k.type_pkpt"))
      ->join("mst_skpd AS skpd", "skpd.id", "=", "k.id_skpd")
      ->join("mst_wilayah AS w", "w.id", "=", "k.id_wilayah")
      ->where("k.is_deleted", 0)
      ->orderBy('k.id', 'ASC');
      return Datatables::of($data)->make(true);
    }

    public function get_kegiatan_by_id(Request $request)
    {
      $data = Kegiatan::find($request->input('id'));

      return response()->json($data);
    }

    public function get_sasaran_by_id_kegiatan(Request $request)
    {
      $data = Sasaran::where('id_kegiatan', $request->input('id'))
      ->where('is_deleted', 0)
      ->orderBy('id', 'ASC')
      ->get();

      return response()->json($data);
    }
}
