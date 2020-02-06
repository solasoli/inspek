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

date_default_timezone_set('Asia/Jakarta');

class SasaranController extends Controller
{
    public function index()
    {
      return view('mst.sasaran-list');
    }

    public function create()
    {
      $parent = Sasaran::where("is_deleted",0)->where("id_parent",0)->get();
      return view('mst.sasaran-form',[
        'parent' => $parent
      ]);
    }

    public function store(Request $request)
    {
      $logged_user = Auth::user();
      request()->validate([
        'nama' => [
        	'required'
	      ]
      ],[
        'nama.required' => 'Nama Sasaran harus diisi!',
        'nama.unique' => 'Nama Sasaran sudah ada!'
      ]);

      $t = new Sasaran;
      $t->nama = $request->input('nama');
      $t->id_parent = $request->input('parent') > 0 ? $request->input('parent') : 0;
      $t->created_at = date('Y-m-d H:i:s');
      $t->created_by = Auth::id();
      $t->updated_at = NULL;
      $t->updated_by = 0;
      $t->deleted_at = NULL;
      $t->deleted_by = 0;
      $t->is_deleted = 0;
      $t->save();


      $request->session()->flash('message', "<strong>".$request->input('nama')."</strong> Berhasil disimpan!");
      return redirect('/mst/sasaran');
    }

    public function edit($id)
    {
      $data = Sasaran::find($id);

      $parent = Sasaran::where("is_deleted",0)->where("id_parent",0)->get();

      return view('mst.sasaran-form', [
        'data' => $data,
        'parent' => $parent
      ]);
    }

    public function update(Request $request, $id)
    {
      $logged_user = Auth::user();

      $request->validate([
        'nama' => [
        	'required'
	      ]
      ],[
        'nama.required' => 'Nama Sasaran harus diisi!',
        'nama.unique' => 'Nama Sasaran sudah ada!'
      ]);

      $t = Sasaran::findOrFail($id);
      $t->nama = $request->input('nama');
      $t->id_parent = $request->input('parent') > 0 ? $request->input('parent') : 0;
      $t->updated_at = date('Y-m-d H:i:s');
      $t->updated_by = Auth::id();
      $t->save();

      $request->session()->flash('message', "Data berhasil diubah!");
      return redirect('/mst/sasaran');
    }

    public function destroy(Request $request, $id)
    {
      $logged_user = Auth::user();
      $t = Sasaran::findOrFail($id);
      $t->deleted_at = date('Y-m-d H:i:s');
      $t->deleted_by = Auth::id();
      $t->is_deleted = 1;
      $t->save();

      $request->session()->flash('message', "<strong>".$t->nama."</strong> berhasil Dihapus!");
      return redirect('/mst/sasaran');
    }

    public function list_datatables_api()
    {
      $data = DB::table("mst_sasaran AS s")
      ->select(DB::raw("s.id, s.nama, p.nama AS nama_parent"))
      ->leftJoin("mst_sasaran AS p", "p.id", "=", "s.id_parent")
      ->where("s.is_deleted", 0)
      ->orderBy('s.nama', 'ASC');
      return Datatables::of($data)->make(true);
    }
}
