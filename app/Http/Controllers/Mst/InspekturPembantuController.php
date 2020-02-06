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
use App\InspekturPembantu;
use App\Skpd;
use App\Model\Pegawai\Pegawai;

date_default_timezone_set('Asia/Jakarta');

class InspekturPembantuController extends Controller
{
    public function index()
    {
      return view('mst.inspektur_pembantu-list');
    }

    public function create($id_wilayah = null)
    {
      $wilayah = Wilayah::where("is_deleted", 0)->get();
      $inspektur_wilayah = $wilayah->map(function($val, $itm){
        return $val->id_inspektur;
      });

      $pegawai = Pegawai::where("is_deleted",0)->whereNotIn("id", $inspektur_wilayah)->get();
      $data = InspekturPembantu::where("is_deleted", 0)->where("id_wilayah", $id_wilayah)->get();
      $wilayah_selected = DB::table("mst_wilayah AS w")
      ->select(DB::raw("w.id, w.nama, p.nama AS nama_inspektur, p.id AS id_inspektur"))
      ->join("pgw_pegawai AS p", "p.id", "=", "w.id_inspektur")
      ->where('p.is_deleted', 0)
      ->where("w.is_deleted", 0)
      ->where("w.id", $id_wilayah)
      ->first();
      return view('mst.inspektur_pembantu-form',[
        'pegawai' => $pegawai,
        'wilayah' => $wilayah,
        'data' => $data,
        'wilayah_selected' => $wilayah_selected
      ]);
    }

    public function store(Request $request, $id_wilayah = 0)
    {
      $logged_user = Auth::user();
      request()->validate([
        'wilayah' => [
        	'required'
	      ]
      ],[
        'nama.required' => 'Wilayah harus dipilih!',
        'nama.unique' => 'Wilayah sudah ada!'
      ]);

      $t = Wilayah::findOrFail($id_wilayah);

      DB::update("UPDATE mst_inspektur_pembantu SET is_deleted = 1 WHERE id_wilayah = {$id_wilayah}");
      if(count($request->input("pegawai")) > 0){
        foreach($request->input("pegawai") as $idx => $row){

          if($row > 0){
            //insert into  wilayah opd
            $inspektur_pb = new InspekturPembantu;
            $inspektur_pb->id_wilayah = $t->id;
            $inspektur_pb->id_inspektur_pembantu = $row;
            $inspektur_pb->save();
          }
        }
      }

      $request->session()->flash('message', "<strong>".$request->input('nama')."</strong> Berhasil disimpan!");
      return redirect('/mst/inspektur_pembantu/form/'. $id_wilayah);
    }


    public function get_inspektur_pembantu_by_wilayah(Request $request)
    {
      $id_wilayah = $request->input("id_wilayah") > 0 ? $request->input("id_wilayah") : 0; 
      $data = DB::table("mst_wilayah AS w")
      ->select(DB::raw("w.id, w.nama, p.nama AS nama_inspektur, p.id AS id_inspektur"))
      ->join("pgw_pegawai AS p", "p.id", "=", "w.id_inspektur")
      ->where('p.is_deleted', 0)
      ->where("w.is_deleted", 0)
      ->where("w.id", $id_wilayah)
      ->orderBy('w.nama', 'ASC')
      ->get();
      return response()->json(["data" => $data]);
    }
}
