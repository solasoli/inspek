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
use App\Wilayah;
use App\WilayahSkpd;
use App\WilayahAnggota;
use App\Skpd;
use App\Model\Pegawai\Pegawai;

date_default_timezone_set('Asia/Jakarta');

class WilayahController extends Controller
{
    public function index()
    {
      return view('Mst.wilayah-list');
    }

    public function create()
    {
      $pegawai = Pegawai::where("is_deleted",0)->get();
      $skpd = Skpd::where("is_deleted",0)->get();
      return view('Mst.wilayah-form',[
        'pegawai' => $pegawai,
        'skpd' => $skpd
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
        'nama.required' => 'Nama Wilayah harus diisi!',
        'nama.unique' => 'Nama Wilayah sudah ada!'
      ]);

      $t = new Wilayah;
      $t->nama = $request->input('nama');
      $t->id_inspektur_pembantu = 0;
      $t->created_at = date('Y-m-d H:i:s');
      $t->created_by = Auth::id();
      $t->updated_at = NULL;
      $t->updated_by = 0;
      $t->deleted_at = NULL;
      $t->deleted_by = 0;
      $t->is_deleted = 0;
      $t->save();

      // if(count($request->input("opd")) > 0){
      //   foreach($request->input("opd") as $idx => $row){
      //     if($row > 0){
      //       //insert into  wilayah opd
      //       $wilayah_skpd = new WilayahSkpd;
      //       $wilayah_skpd->id_wilayah = $t->id;
      //       $wilayah_skpd->id_skpd = $row;
      //       $wilayah_skpd->save();
      //     }
      //   }
      // }

      $request->session()->flash('success', "<strong>".$request->input('nama')."</strong> Berhasil disimpan!");
      return redirect('/mst/wilayah');
    }

    public function edit($id)
    {
      $data = Wilayah::find($id);

      $pegawai = Pegawai::where("is_deleted",0)->get();
      $skpd = Skpd::where("is_deleted",0)->get();
      $opd_wilayah = WilayahSkpd::where("is_deleted", 0)->where("id_wilayah", $id)->get();
      $anggota = WilayahAnggota::where("is_deleted", 0)->where("id_wilayah", $id)->get();

      return view('Mst.wilayah-form', [
        'data' => $data,
        'pegawai' => $pegawai,
        'skpd' => $skpd,
        'list_opd' => $opd_wilayah,
        'anggota' => $anggota
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
        'nama.required' => 'Nama Wilayah harus diisi!',
        'nama.unique' => 'Nama Wilayah sudah ada!'
      ]);

      $t = Wilayah::findOrFail($id);
      $t->nama = $request->input('nama');
      $t->id_inspektur_pembantu = 0;
      $t->updated_at = date('Y-m-d H:i:s');
      $t->updated_by = Auth::id();
      $t->save();

      //remove the last wilayah opd first
      // DB::update("UPDATE mst_wilayah_skpd SET is_deleted = 1 WHERE id_wilayah = {$t->id}");
      //
      // if(count($request->input("opd")) > 0){
      //   foreach($request->input("opd") as $idx => $row){
      //     if($row > 0){
      //       //insert into  wilayah opd
      //       $wilayah_skpd = new WilayahSkpd;
      //       $wilayah_skpd->id_wilayah = $t->id;
      //       $wilayah_skpd->id_skpd = $row;
      //       $wilayah_skpd->save();
      //     }
      //   }
      // }

      $request->session()->flash('success', "Data berhasil diubah!");
      return redirect('/mst/wilayah');
    }

    public function destroy(Request $request, $id)
    {
      $logged_user = Auth::user();
      $t = Wilayah::findOrFail($id);
      $t->deleted_at = date('Y-m-d H:i:s');
      $t->deleted_by = Auth::id();
      $t->is_deleted = 1;
      $t->save();

      $request->session()->flash('success', "<strong>".$t->nama."</strong> berhasil Dihapus!");
      return redirect('/mst/wilayah');
    }

    public function list_datatables_api()
    {
      $data = DB::table("mst_wilayah AS w")
      ->select(DB::raw("w.id, w.nama, p.nama AS nama_inspektur, p.id AS id_inspektur_pembantu"))
      ->leftJoin("pgw_pegawai AS p", function($join){
        return $join->on("p.id", "=", "w.id_inspektur_pembantu")
        ->where("p.is_deleted", 0);
      })
      ->where("w.is_deleted", 0)
      ->orderBy('w.nama', 'ASC');
      return Datatables::of($data)->make(true);
    }

    public function get_wilayah_by_id(Request $request)
    {
      $data = Wilayah::find($request->input('id'));

      return response()->json($data);
    }
}
