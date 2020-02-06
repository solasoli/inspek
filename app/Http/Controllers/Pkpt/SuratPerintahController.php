<?php

namespace App\Http\Controllers\Pkpt;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Datatables;
use Validator;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Input;
use App\SuratPerintah;
use App\Skpd;
use App\Wilayah;
use App\Sasaran;
use App\DasarSurat;
use App\Model\Pegawai\Pegawai;

date_default_timezone_set('Asia/Jakarta');

class SuratPerintahController extends Controller
{
    public function index()
    {
      return view('pkpt.surat_perintah-list');
    }

    public function create()
    {
      $wilayah = DB::table("mst_wilayah AS w")
      ->select(DB::raw("w.id, w.nama, p.nama AS nama_inspektur, p.id AS id_inspektur"))
      ->join("pgw_pegawai AS p", "p.id", "=", "w.id_inspektur")
      ->where('p.is_deleted', 0)
      ->where("w.is_deleted", 0)
      ->orderBy('w.nama', 'ASC')
      ->get();

      $inspektur_wilayah = $wilayah->map(function($val, $itm){
        return $val->id_inspektur;
      });

      $pegawai = Pegawai::where("is_deleted",0)->whereNotIn("id", $inspektur_wilayah)->get();
      $skpd = Skpd::where("is_deleted",0)->get();
      $sasaran = Sasaran::where("is_deleted", 0)->get();
      $dasar_surat = DasarSurat::first();
      return view('pkpt.surat_perintah-form',[
        'pegawai' => $pegawai,
        'skpd' => $skpd,
        'wilayah' => $wilayah,
        'sasaran' => $sasaran,
        'dasar_surat' => $dasar_surat
      ]);
    }

    public function store(Request $request)
    {
      $logged_user = Auth::user();
      request()->validate([
        'nama' => [
        	'required'
	      ],
        'inspektur' => [
          'required'
        ]
      ],[
        'nama.required' => 'Nama SuratPerintah harus diisi!',
        'nama.unique' => 'Nama SuratPerintah sudah ada!'
      ]);

      $t = new SuratPerintah;
      $t->nama = $request->input('nama');
      $t->id_inspektur = $request->input('inspektur');
      $t->created_at = date('Y-m-d H:i:s');
      $t->created_by = Auth::id();
      $t->updated_at = NULL;
      $t->updated_by = 0;
      $t->deleted_at = NULL;
      $t->deleted_by = 0;
      $t->is_deleted = 0;
      $t->save();

      if(count($request->input("opd")) > 0){
        foreach($request->input("opd") as $idx => $row){
          if($row > 0){
            //insert into  wilayah opd
            $wilayah_skpd = new SuratPerintahSkpd;
            $wilayah_skpd->id_wilayah = $t->id;
            $wilayah_skpd->id_skpd = $row;
            $wilayah_skpd->save();
          }
        }
      }

      $request->session()->flash('message', "<strong>".$request->input('nama')."</strong> Berhasil disimpan!");
      return redirect('/mst/wilayah');
    }

    public function edit($id)
    {
      $data = SuratPerintah::find($id);

      $pegawai = Pegawai::where("is_deleted",0)->get();
      $skpd = Skpd::where("is_deleted",0)->get();
      $opd_wilayah = SuratPerintahSkpd::where("is_deleted", 0)->where("id_wilayah", $id)->get();

      return view('pkpt.surat_perintah-form', [
        'data' => $data,
        'pegawai' => $pegawai,
        'skpd' => $skpd,
        'list_opd' => $opd_wilayah
      ]);
    }

    public function update(Request $request, $id)
    {
      $logged_user = Auth::user();

      $request->validate([
        'nama' => [
        	'required'
	      ],
        'inspektur' => [
          'required'
        ]
      ],[
        'nama.required' => 'Nama SuratPerintah harus diisi!',
        'nama.unique' => 'Nama SuratPerintah sudah ada!'
      ]);

      $t = SuratPerintah::findOrFail($id);
      $t->nama = $request->input('nama');
      $t->id_inspektur = $request->input('inspektur');
      $t->updated_at = date('Y-m-d H:i:s');
      $t->updated_by = Auth::id();
      $t->save();

      //remove the last wilayah opd first
      DB::update("UPDATE mst_wilayah_skpd SET is_deleted = 1 WHERE id_wilayah = {$t->id}");

      if(count($request->input("opd")) > 0){
        foreach($request->input("opd") as $idx => $row){
          if($row > 0){
            //insert into  wilayah opd
            $wilayah_skpd = new SuratPerintahSkpd;
            $wilayah_skpd->id_wilayah = $t->id;
            $wilayah_skpd->id_skpd = $row;
            $wilayah_skpd->save();
          }
        }
      }

      $request->session()->flash('message', "Data berhasil diubah!");
      return redirect('/mst/wilayah');
    }

    public function destroy(Request $request, $id)
    {
      $logged_user = Auth::user();
      $t = SuratPerintah::findOrFail($id);
      $t->deleted_at = date('Y-m-d H:i:s');
      $t->deleted_by = Auth::id();
      $t->is_deleted = 1;
      $t->save();

      $request->session()->flash('message', "<strong>".$t->nama."</strong> berhasil Dihapus!");
      return redirect('/mst/wilayah');
    }

    public function list_datatables_api()
    {
      $data = DB::table("mst_wilayah AS w")
      ->select(DB::raw("w.id, w.nama, p.nama AS nama_inspektur, p.id AS id_inspektur"))
      ->join("pgw_pegawai AS p", "p.id", "=", "w.id_inspektur")
      ->where('p.is_deleted', 0)
      ->where("w.is_deleted", 3)
      ->orderBy('w.nama', 'ASC');
      return Datatables::of($data)->make(true);
    }
}
