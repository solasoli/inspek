<?php
namespace App\Http\Controllers\Mst;

use App\Export\PegawaiExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Datatables;
use Illuminate\Support\Facades\DB;
use App\Repository\Pegawai\Pegawai;
use App\Inspektur;
use App\Service\Pegawai\PegawaiService;
use App\Http\Requests\Master\PegawaiRequest;
use Maatwebsite\Excel\Facades\Excel;

date_default_timezone_set('Asia/Jakarta');

class PegawaiController extends Controller
{
    public function index()
    {
      $data = PegawaiService::data_for_form();
      return view('Mst.pegawai-list', $data);
    }

    public function store(PegawaiRequest $request)
    {
      PegawaiService::create($request->input());
      $request->session()->flash('success', "Data berhasil disimpan!");
      return response()->json(['success' => true]);
    }

    public function update(PegawaiRequest $request, $id)
    {
      PegawaiService::update($id, $request->input());
      $request->session()->flash('success', "Data berhasil disimpan!");
      return response()->json(['success' => true]);
    }

    public function destroy(Request $request, $id)
    {
      PegawaiService::delete($id);

      $request->session()->flash('success', "Data berhasil Dihapus!");
      return redirect('/mst/pegawai');
    }

    public function list_datatables_api()
    {
      $data = Pegawai::with(['pangkat_golongan', 'jabatan'])->where('pgw_pegawai.is_deleted', 0)
      ->orderByRaw('id_jabatan = 29 DESC, id_jabatan = 56 DESC, id_jabatan = 49 DESC, id_jabatan = 74 DESC, id_jabatan = 36 DESC');

      return Datatables::eloquent($data)->toJson();
    }

    public function inspektur(){

      $pegawai = Pegawai::where("is_deleted",0)->get();
      $current_inspektur =PegawaiService::get_current_inspektur();
      return view('Mst.inspektur-form', [
        'pegawai' => $pegawai,
        'inspektur' => $current_inspektur
      ]);
    }

    public function update_inspektur(Request $request) {
      //update other inspektur flag to 0
      DB::update("UPDATE mst_inspektur SET is_current_inspektur = 0");

      //insert new
      $new_ins = new Inspektur;
      $new_ins->id_inspektur = $request->inspektur;
      $new_ins->is_current_inspektur = 1;
      $new_ins->save();

      $request->session()->flash('success', "<strong>".$request->input('nama')."</strong> Berhasil disimpan!");
      return redirect('/mst/pegawai/inspektur');

    }

    public function get_inspektur_pembantu_by_wilayah(Request $request)
    {
      $id_wilayah = $request->input("id_wilayah") != '' ? $request->input("id_wilayah") : [];

      $data = PegawaiService::get_inspektur_pembantu_by_wilayah($id_wilayah);
      return response()->json(["data" => $data]);
    }


    public function get_pengendali_teknis_by_wilayah(Request $request)
    {
      $id_wilayah = $request->input("id_wilayah") != '' ? $request->input("id_wilayah") : [];
      $data = PegawaiService::get_pengendali_teknis_by_wilayah($id_wilayah);

      return response()->json(["data" => $data]);
    }

    public function get_ketua_tim_by_wilayah(Request $request)
    {
      $id_wilayah = $request->input("id_wilayah") != '' ? $request->input("id_wilayah") : [];
      $data = PegawaiService::get_ketua_tim_by_wilayah($id_wilayah);
      return response()->json(["data" => $data]);
    }


    public function get_anggota_by_wilayah(Request $request)
    {
      $id_wilayah = $request->input("id_wilayah") != '' ? $request->input("id_wilayah") : [];
      $data = [];
      if(!is_null($request->input("id_wilayah"))) {
        if($request->input('id_wilayah') != 'all') {
          $data = PegawaiService::get_anggota(true, $id_wilayah)->get();
        } else {
          $data = PegawaiService::get_anggota(true)->get();
        }
      }
      return response()->json(["data" => $data]);
    }

    public function get_pegawai_by_id(Request $request, $id)
    {
      $data = Pegawai::find($id);

      return response()->json($data);
    }

    public function print($method = 'html')
    {
      if($method == 'html') {
        $data = Pegawai::where('is_deleted', 0)->orderBy('nama_asli')->get();
        return view('Mst.pegawai-print', [
          'data' => $data
        ]);
      } else if($method == 'excel') {
        return Excel::download(new PegawaiExport, 'Data Pegawai.xlsx');
      }
    }
}
