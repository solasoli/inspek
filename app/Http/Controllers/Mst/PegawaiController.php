<?php
namespace App\Http\Controllers\Mst;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Datatables;
use Illuminate\Support\Facades\DB;
use App\Repository\Pegawai\Pegawai;
use App\Inspektur;
use App\Service\Pegawai\PegawaiService;
use App\Http\Requests\Master\PegawaiRequest;

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
      $data = Pegawai::with(['pangkat_golongan', 'jabatan'])->where('is_deleted', 0);

      return Datatables::eloquent($data)->toJson();
    }

    public function inspektur(){

      $pegawai = Pegawai::where("is_deleted",0)->get();
      $current_inspektur = $this->get_current_inspektur(true);
      return view('Mst.inspektur-form', [
        'pegawai' => $pegawai,
        'inspektur' => $current_inspektur
      ]);
    }

    public function update_inspektur(Request $request) {
      //check if current inspektur == input
      $current_inspektur = $this->get_current_inspektur(true);
      if($current_inspektur == null || $current_inspektur->id_inspektur != $request->inspektur){
        //update other inspektur flag to 0
        DB::update("UPDATE mst_inspektur SET is_current_inspektur = 0");

        //insert new
        $new_ins = new Inspektur;
        $new_ins->id_inspektur = $request->inspektur;
        $new_ins->is_current_inspektur = 1;
        $new_ins->save();
      }

      $request->session()->flash('success', "<strong>".$request->input('nama')."</strong> Berhasil disimpan!");
      return redirect('/mst/pegawai/inspektur');

    }

    public function get_inspektur_pembantu_by_wilayah(Request $request)
    {
      $id_wilayah = $request->input("id_wilayah") > 0 ? $request->input("id_wilayah") : 0;

      $data = PegawaiService::get_inspektur_pembantu_by_wilayah($id_wilayah);
      return response()->json(["data" => $data]);
    }


    public function get_pengendali_teknis_by_wilayah(Request $request)
    {
      $data = PegawaiService::get_pengendali_teknis_by_wilayah($request->input('id_wilayah'));
      return response()->json(["data" => $data]);
    }

    public function get_ketua_tim_by_wilayah(Request $request)
    {
      $data = PegawaiService::get_ketua_tim_by_wilayah($request->input('id_wilayah'));
      return response()->json(["data" => $data]);
    }


    public function get_anggota_by_wilayah(Request $request)
    {
      $id_wilayah = $request->input("id_wilayah") > 0 ? $request->input("id_wilayah") : 0;

      if($request->input('id_wilayah') != 'all') {
        $data = PegawaiService::get_anggota(true, $id_wilayah);
      } else {
        $data = PegawaiService::get_anggota(true);
      }
      return response()->json(["data" => $data->get()]);
    }

    public function get_pegawai_by_id(Request $request, $id)
    {
      $data = Pegawai::find($id);

      return response()->json($data);
    }
}
