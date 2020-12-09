<?php

namespace App\Http\Controllers\Mst;

use App\Http\Controllers\Controller;
use App\Repository\Pegawai\Jabatan;
use Illuminate\Http\Request;
use Datatables;
use Validator;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Input;

date_default_timezone_set('Asia/Jakarta');

class JabatanController extends Controller
{
    public function index()
    {
      return view('Mst.jabatan-list');
    }

    public function create()
    {
      return view('Mst.jabatan-form');
    }

    public function store(Request $request)
    {
      $logged_user = Auth::user();
      request()->validate([
        'nama' => [
        	'required'
	      ],
        // 'inspektur' => [
        //   'required'
        // ]
      ],[
        'nama.required' => 'Nama Jabatan harus diisi!',
        'nama.unique' => 'Nama Jabatan sudah ada!'
      ]);

      $t = new Jabatan;
      $t->name = $request->input('nama');
      $t->is_deleted = 0;
      $t->save();

      $request->session()->flash('message', "<strong>".$request->input('nama')."</strong> Berhasil disimpan!");
      return redirect('/mst/jabatan');
    }

    public function edit($id)
    {
      $data = Jabatan::find($id);


      return view('Mst.jabatan-form', [
        'data' => $data,
      ]);
    }

    public function update(Request $request, $id)
    {
      $logged_user = Auth::user();

      $request->validate([
        'nama' => [
        	'required'
	      ],
        // 'inspektur' => [
        //   'required'
        // ]
      ],[
        'nama.required' => 'Nama Jabatan harus diisi!',
        'nama.unique' => 'Nama Jabatan sudah ada!'
      ]);

      $t = Jabatan::findOrFail($id);
      $t->name = $request->input('nama');
      $t->save();


      $request->session()->flash('message', "Data berhasil diubah!");
      return redirect('/mst/jabatan');
    }

    public function destroy(Request $request, $id)
    {
      $logged_user = Auth::user();
      $t = Jabatan::findOrFail($id);
      $t->is_deleted = 1;
      $t->save();

      $request->session()->flash('message', "<strong>".$t->nama."</strong> berhasil Dihapus!");
      return redirect('/mst/jabatan');
    }

    public function list_datatables_api()
    {
      $data = Jabatan::where("is_deleted", 0);
      return Datatables::of($data)->make(true);
    }
}
