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
use App\Repository\Master\Kegiatan;
use App\Repository\Master\Skpd;
use App\Repository\Master\Wilayah;
use App\Repository\Master\ProgramKerja;
use App\Service\Master\ProgramKerjaService;
use App\Service\Master\KegiatanService;
use App\Http\Requests\Master\ProgramKerjaRequest;

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

    public function store(ProgramKerjaRequest $request)
    {
      ProgramKerjaService::create($request->input());
      $request->session()->flash('success', "Data berhasil disimpan!");
      return response()->json(['success' => true]);
    }

    public function update(ProgramKerjaRequest $request, $id)
    {
      ProgramKerjaService::update($id, $request->input());
      $request->session()->flash('success', "Data berhasil disimpan!");
      return response()->json(['success' => true]);
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
      });

      $request->session()->flash('success', "Data berhasil Dihapus!");
      return redirect('/mst/program_kerja');
    }

    public function list_datatables_api()
    {
      $data = ProgramKerja::with(['skpd', 'kegiatan', 'wilayah'])->where('is_deleted', 0);
      return Datatables::eloquent($data)->toJson();
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
