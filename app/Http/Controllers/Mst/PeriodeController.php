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
use App\Periode;

date_default_timezone_set('Asia/Jakarta');

class PeriodeController extends Controller
{
    public function index()
    {
      return view('Mst.periode-list');
    }

    public function create()
    {
      return view('Mst.periode-form');
    }

    public function store(Request $request)
    {
      $logged_user = Auth::user();
      request()->validate([
        'periode_awal' => 'required',
        'periode_akhir' => 'required'
      ],[
        'periode_awal.required' => 'Periode Awal harus diisi!',
        'periode_akhir.required' => 'Periode Akhir harus diisi!',
        'walikota.required' => 'Walikota harus diisi!'
      ]);

      $t = new Periode;
      $t->start_year = $request->input('periode_awal');
      $t->end_year = $request->input('periode_akhir');
      $t->label = $request->input('periode_awal'). " - ".$request->input('periode_akhir');
      $t->created_at = date('Y-m-d H:i:s');
      $t->created_by = Auth::id();
      $t->updated_at = NULL;
      $t->updated_by = 0;
      $t->deleted_at = NULL;
      $t->deleted_by = 0;
      $t->is_deleted = 0;
      $t->save();

      $request->session()->flash('message', "<strong>".$request->input('nama')."</strong> Berhasil disimpan!");
      return redirect('/mst/periode');
    }

    public function edit($id)
    {
      $data = Periode::find($id);

      return view('Mst.periode-form', ['data' => $data]);
    }

    public function update(Request $request, $id)
    {
      $logged_user = Auth::user();
      request()->validate([
        'periode_awal' => 'required',
        'periode_akhir' => 'required'
      ],[
        'periode_awal.required' => 'Periode Awal harus diisi!',
        'periode_akhir.required' => 'Periode Akhir harus diisi!',
        'walikota.required' => 'Walikota harus diisi!'
      ]);

      $t = Periode::findOrFail($id);
      $t->start_year = $request->input('periode_awal');
      $t->end_year = $request->input('periode_akhir');
      $t->label = $request->input('periode_awal'). " - ".$request->input('periode_akhir');
      $t->updated_at = date('Y-m-d H:i:s');
      $t->updated_by = Auth::id();
      $t->save();

      $request->session()->flash('message', "Data berhasil diubah!");
      return redirect('/mst/periode');
    }

    public function destroy(Request $request, $id)
    {
      $logged_user = Auth::user();
      $t = Periode::findOrFail($id);
      $t->deleted_at = date('Y-m-d H:i:s');
      $t->deleted_by = Auth::id();
      $t->is_deleted = 1;
      $t->save();

      $request->session()->flash('message', "<strong>".$t->name."</strong> berhasil Dihapus!");
      return redirect('/mst/periode');
    }

    public function list_datatables_api()
    {
      $data = Periode::where('is_deleted', 0)->orderBy('label', 'ASC')->get();
      return Datatables::of($data)->make(true);
    }
}
