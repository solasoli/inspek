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
      return view('mst.skpd-list');
    }

    public function create()
    {
      return view('mst.skpd-form');
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
      $t->singkatan_pimpinan = $request->input('singkatan_pimpinan');
      $t->created_at = date('Y-m-d H:i:s');
      $t->created_by = Auth::id();
      $t->updated_at = NULL;
      $t->updated_by = 0;
      $t->deleted_at = NULL;
      $t->deleted_by = 0;
      $t->is_deleted = 0;
      $t->save();


      $request->session()->flash('message', "<strong>".$request->input('name')."</strong> Berhasil disimpan!");
      return redirect('/master/skpd');
    }

    public function edit($id)
    {
      $data = Skpd::find($id);

      return view('mst.skpd-form', ['data' => $data]);
    }

    public function update(Request $request, $id)
    {
      $logged_user = Auth::user();

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
      $t->singkatan_pimpinan = $request->input('singkatan_pimpinan');
      $t->updated_at = date('Y-m-d H:i:s');
      $t->updated_by = Auth::id();
      $t->save();

      $request->session()->flash('message', "Data berhasil diubah!");
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

      $request->session()->flash('message', "<strong>".$t->name."</strong> berhasil Dihapus!");
      return redirect('/mst/skpd');
    }

    public function list_datatables_api()
    {
      $data = Skpd::where('is_deleted', 0)->orderBy('name', 'ASC')->get();
      return Datatables::of($data)->make(true);
    }
}
