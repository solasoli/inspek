<?php

namespace App\Http\Controllers\Mst;

use App\Http\Controllers\Controller;
use App\Repository\Pegawai\Jabatan;
use App\Repository\Pegawai\Peran;
use App\Repository\Pegawai\PeranJabatan;
use Illuminate\Http\Request;
use Datatables;
use Validator;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Input;

date_default_timezone_set('Asia/Jakarta');

class PeranController extends Controller
{
    public function index()
    {
      return view('Mst.peran-list');
    }

    public function create()
    {
      $jabatan = Jabatan::where("is_deleted", 0)->orderBy('name')->get();
      return view('Mst.peran-form',[
        'jabatan' => $jabatan,
      ]);
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
        'nama.required' => 'Nama Peran harus diisi!',
        'nama.unique' => 'Nama Peran sudah ada!'
      ]);

      $t = new Peran();
      $t->nama = $request->input('nama');
      $t->kode = $request->input('kode');
      $t->created_at = date('Y-m-d H:i:s');
      $t->created_by = Auth::id();
      $t->updated_at = NULL;
      $t->updated_by = 0;
      $t->deleted_at = NULL;
      $t->deleted_by = 0;
      $t->is_deleted = 0;
      $t->save();

      // save to peran jabatan
      foreach($request->input('jabatan') as $idx => $row){
        $tj = new PeranJabatan();
        $tj->id_peran = $t->id;
        $tj->id_jabatan = $row;
        $tj->save(); 
      }

      $request->session()->flash('message', "<strong>".$request->input('nama')."</strong> Berhasil disimpan!");
      return redirect('/mst/peran');
    }

    public function edit($id)
    {
      $data = Peran::find($id);
      $peran_jabatan = PeranJabatan::where("id_peran", $id)->where("is_deleted",0)->get();

      $jabatan = Jabatan::where("is_deleted", 0)->orderBy('name')->get();

      return view('Mst.peran-form', [
        'data' => $data,
        'jabatan' => $jabatan,
        'peran_jabatan' => $peran_jabatan,
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
        'nama.required' => 'Nama Peran harus diisi!',
        'nama.unique' => 'Nama Peran sudah ada!'
      ]);

      $t = Peran::findOrFail($id);
      $t->nama = $request->input('nama');
      $t->kode = $request->input('kode');
      $t->updated_at = date('Y-m-d H:i:s');
      $t->updated_by = Auth::id();
      $t->save();

      // update peran jabatan to is_deleted 1
      DB::update("UPDATE pgw_peran_jabatan SET is_deleted = 1 WHERE id_peran = {$t->id}");


      // save to peran jabatan
      foreach($request->input('jabatan') as $idx => $row){
        $tj = new PeranJabatan;
        $tj->id_peran = $t->id;
        $tj->id_jabatan = $row;
        $tj->save(); 
      }


      $request->session()->flash('message', "Data berhasil diubah!");
      return redirect('/mst/peran');
    }

    public function destroy(Request $request, $id)
    {
      $logged_user = Auth::user();
      $t = Peran::findOrFail($id);
      $t->is_deleted = 1;
      $t->save();

      $request->session()->flash('message', "<strong>".$t->nama."</strong> berhasil Dihapus!");
      return redirect('/mst/peran');
    }

    public function list_datatables_api()
    {
      $data = Peran::where("is_deleted", 0)
      ->where("is_anggota", 0);
      return Datatables::of($data)->make(true);
    }

    public function get_peran_by_jabatan($id){
      $peran_jabatan = PeranJabatan::where("id_jabatan", $id)->where("is_deleted", 0)->get();
      $peran_jabatan_ids = $peran_jabatan->map(function($val, $id){
        return $val->id_peran;
      });

      $peran = Peran::select('id', 'nama')
      ->where('is_deleted', 0)
      ->whereIn('id', $peran_jabatan_ids)
      ->orWhere('is_anggota', 1)->get();

      return response()->json(['data' => $peran]);
    }
}
