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
use App\Kegiatan;
use App\Skpd;
use App\Wilayah;
use App\Service\ProgramKerjaService;
use App\Service\KegiatanService;
use App\ProgramKerja;

date_default_timezone_set('Asia/Jakarta');

class ProgramKerjaController extends Controller
{
    public function index()
    {
      $opd = Skpd::where("is_deleted", 0)->get();
      $wilayah = Wilayah::where("is_deleted", 0)->get();
      $program_kerja = ProgramKerja::where("is_deleted", 0)->get();
      return view('Mst.program_kerja-list', [
        'opd' => $opd,
        'program_kerja' => $program_kerja,
        'wilayah' => $wilayah,
      ]);
    }

    public function create()
    {
      $parent = Sasaran::where("is_deleted",0)->where("id_parent",0)->get();
      return view('Mst.program_kerja-form',[
        'parent' => $parent
      ]);
    }

    public function store(Request $request)
    {
      $logged_user = Auth::user();
      request()->validate([
        'sub_kegiatan' => 'required',
        'wilayah' => 'required',
        'opd' => 'required',
        'dari' => 'required',
        'sampai' => 'required',
        'sasaran' => 'required',
      ],[
        'sub_kegiatan.required' => 'Sub Kegiatan Sasaran harus diisi!',
        'sub_kegiatan.unique' => 'Sub Kegiatan Sasaran sudah ada!',
        'wilayah.required' => 'Irban harus diisi!',
        'opd.required' => 'Perangkat Daerah harus diisi!',
        'dari.required' => 'Dari harus diisi!',
        'sampai.required' => 'Sampai harus diisi!',
      ]);

      // dd($request->input());
      ProgramKerjaService::create($request->input());

      $request->session()->flash('success', "<strong>".$request->input('sub_kegiatan')."</strong> Berhasil disimpan!");
      return redirect('/mst/program_kerja');
    }

    public function edit($id)
    {
      $data = Sasaran::find($id);

      $parent = Sasaran::where("is_deleted",0)->where("id_parent",0)->get();

      return view('Mst.program_kerja-form', [
        'data' => $data,
        'parent' => $parent
      ]);
    }

    public function update(Request $request, $id)
    {
      $logged_user = Auth::user();
      request()->validate([
        'sub_kegiatan' => 'required',
        'wilayah' => 'required',
        'opd' => 'required',
        'dari' => 'required',
        'sampai' => 'required',
        'sasaran' => 'required',
      ],[
        'sub_kegiatan.required' => 'Sub Kegiatan harus diisi!',
        'sub_kegiatan.unique' => 'Sub Kegiatan sudah ada!',
        'wilayah.required' => 'Irban harus diisi!',
        'opd.required' => 'Perangkat Daerah harus diisi!',
        'dari.required' => 'Dari harus diisi!',
        'sampai.required' => 'Sampai harus diisi!',
      ]);

      ProgramKerjaService::update($id, $request->input());

      $request->session()->flash('success', "Data berhasil diubah!");
      return redirect('/mst/program_kerja');
    }

    public function destroy(Request $request, $id)
    {
      $logged_user = Auth::user();

      DB::transaction(function() use ($id) {
        $t = ProgramKerja::findOrFail($id);
        $t->deleted_at = date('Y-m-d H:i:s');
        $t->deleted_by = Auth::id();
        $t->is_deleted = 1;
        $t->save();

        KegiatanService::delete_by_program_kerja($id);
      });

      $request->session()->flash('success', "Data berhasil Dihapus!");
      return redirect('/mst/program_kerja');
    }

    public function list_datatables_api()
    {
      $data = DB::table("mst_program_kerja AS pk")
      ->select(DB::raw("pk.id, pk.sub_kegiatan AS kegiatan, pk.sub_kegiatan AS wilayah, skpd.name AS skpd, pk.dari, pk.sampai, pk.type_pkpt"))
      ->join("mst_skpd AS skpd", "skpd.id", "=", "pk.id_skpd")
      ->join("mst_wilayah AS w", "w.id", "=", "pk.id_wilayah")
      ->where("pk.is_deleted", 0);
      return Datatables::of($data)->make(true);
    }

    public function get_program_kerja_by_id(Request $request)
    {
      $data = ProgramKerja::find($request->input('id'));

      return response()->json($data);
    }

    public function get_sasaran_by_id_kegiatan(Request $request)
    {
      $data = Sasaran::where('id_kegiatan', $request->input('id'))
      ->where('is_deleted', 0)
      ->orderBy('id', 'ASC')
      ->get();

      return response()->json($data);
    }
}
