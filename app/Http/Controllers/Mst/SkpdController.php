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
use App\Skpd;

date_default_timezone_set('Asia/Jakarta');

class SkpdController extends Controller
{
    public function index()
    {
      $pegawai = DB::table('pgw_pegawai')
      ->select('id', 'nama')
      ->where('is_deleted', 0)
      ->orderBy('nama_asli', 'ASC')
      ->get();

      $wilayah_kerja = DB::table('mst_wilayah')
      ->select('id', 'nama')
      ->where('is_deleted', 0)
      ->orderBy('nama', 'ASC')
      ->get();

      return view('Mst.skpd-list', [
        'pegawai' => $pegawai,
        'wilayah_kerja' => $wilayah_kerja
      ]);
    }

    public function create()
    {
      return view('Mst.skpd-form');
    }

    public function store(Request $request)
    {
      $logged_user = Auth::user();
      request()->validate([
        'name' => [
        	'required',
	        Rule::unique('mst_skpd', 'name')->where(function ($query){
	            return $query->where('is_deleted', 0);
	        })
	    ]
      ],[
        'name.required' => 'Nama SKPD harus diisi!',
        'name.unique' => 'Nama SKPD sudah ada!'
      ]);

      $t = new Skpd;
      $t->name = $request->input('name');
      $t->singkatan_pd = $request->input('singkatan_pd');
      $t->pimpinan = $request->input('pimpinan');
      $t->id_wilayah = $request->input('wilayah');
      $t->created_at = date('Y-m-d H:i:s');
      $t->created_by = Auth::id();
      $t->updated_at = NULL;
      $t->updated_by = 0;
      $t->deleted_at = NULL;
      $t->deleted_by = 0;
      $t->is_deleted = 0;
      $t->save();


      $request->session()->flash('success', "<strong>".$request->input('name')."</strong> Berhasil disimpan!");
      return redirect('/mst/skpd');
    }

    public function edit($id)
    {
      $data = Skpd::find($id);

      return view('Mst.skpd-form', ['data' => $data]);
    }

    public function update(Request $request, $id)
    {
      $request->validate([
        'name' => [
        	'required',
	        Rule::unique('mst_skpd', 'name')->where(function ($query) use ($id){
	            return $query->where('is_deleted', 0)->where("id", "!=", $id);
	        })
	    ]
      ],[
        'name.required' => 'Nama SKPD harus diisi!',
        'name.unique' => 'Nama SKPD sudah ada!'
      ]);

      $t = Skpd::findOrFail($id);
      $t->name = $request->input('name');
      $t->singkatan_pd = $request->input('singkatan_pd');
      $t->pimpinan = $request->input('pimpinan');
      $t->id_wilayah = $request->input('wilayah');
      $t->updated_at = date('Y-m-d H:i:s');
      $t->updated_by = Auth::id();
      $t->save();

      $request->session()->flash('success', "Data berhasil diubah!");
      return redirect('/mst/skpd');
    }

    public function destroy(Request $request, $id)
    {
      $logged_user = Auth::user();
      $t = Skpd::findOrFail($id);
      $t->deleted_at = date('Y-m-d H:i:s');
      $t->deleted_by = Auth::id();
      $t->is_deleted = 1;
      $t->save();

      $request->session()->flash('success', "<strong>".$t->name."</strong> berhasil Dihapus!");
      return redirect('/mst/skpd');
    }

    public function list_datatables_api()
    {
      // $data = Skpd::where('is_deleted', 0)->orderBy('name', 'ASC')->get();
      $data = DB::table('mst_skpd AS skpd')
      ->select(DB::raw('skpd.*, w.nama AS wilayah'))
      ->leftjoin('mst_wilayah AS w', function($join) {
        $join->on('w.id', '=', 'skpd.id_wilayah');
        $join->where('w.is_deleted', 0);
      })
      ->where('skpd.is_deleted', 0)
      ->orderBy('skpd.name', 'ASC')
      ->get();

      return Datatables::of($data)->make(true);
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
      $data = Skpd::where('id_wilayah', $request->input('id'))
      ->where('is_deleted', 0)
      ->orderBy('id', 'ASC')
      ->get();

      return response()->json($data);
    }
}
