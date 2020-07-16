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
use App\Skpd;
use App\Kegiatan;

date_default_timezone_set('Asia/Jakarta');

class KegiatanController extends Controller
{

    
    public function index()
    {

      $skpd = Skpd::where('is_deleted', 0)->orderBy('name','asc')->get();

      return view('Mst.kegiatan-list', [
        'skpd' => $skpd
      ]);
    }

    public function create()
    {
      return view('Mst.kegiatan-form');
    }

    public function store(Request $request)
    {
      $logged_user = Auth::user();
      request()->validate([
        'nama' => [
        	'required',
	        Rule::unique('mst_kegiatan', 'nama')->where(function ($query){
	            return $query->where('is_deleted', 0);
	        })
	    ]
      ],[
        'nama.required' => 'Nama SKPD harus diisi!',
        'nama.unique' => 'Nama SKPD sudah ada!'
      ]);

      $t = new Kegiatan;
      $t->nama = $request->input('nama');
      $t->id_skpd = $request->input('skpd');
      $t->created_at = date('Y-m-d H:i:s');
      $t->created_by = Auth::id();
      $t->updated_at = NULL;
      $t->updated_by = 0;
      $t->deleted_at = NULL;
      $t->deleted_by = 0;
      $t->is_deleted = 0;
      $t->save();

      $request->session()->flash('success', "<strong>".$request->input('nama')."</strong> Berhasil disimpan!");
      return redirect('/mst/kegiatan');
    }

    public function edit($id)
    {
      $data = Skpd::find($id);

      return view('Mst.kegiatan-form', ['data' => $data]);
    }

    public function update(Request $request, $id)
    {
      $request->validate([
        'nama' => [
        	'required',
	        Rule::unique('mst_kegiatan', 'nama')->where(function ($query) use ($id){
	            return $query->where('is_deleted', 0)->where("id", "!=", $id);
	        })
	    ]
      ],[
        'nama.required' => 'Nama SKPD harus diisi!',
        'nama.unique' => 'Nama SKPD sudah ada!'
      ]);

      $t = Kegiatan::findOrFail($id);
      $t->nama = $request->input('nama');
      $t->id_skpd = $request->input('skpd');
      $t->updated_at = date('Y-m-d H:i:s');
      $t->updated_by = Auth::id();
      $t->save();

      $request->session()->flash('success', "Data berhasil diubah!");
      return redirect('/mst/kegiatan');
    }

    public function destroy(Request $request, $id)
    {
      $logged_user = Auth::user();
      $t = Kegiatan::findOrFail($id);
      $t->deleted_at = date('Y-m-d H:i:s');
      $t->deleted_by = Auth::id();
      $t->is_deleted = 1;
      $t->save();

      $request->session()->flash('success', "<strong>".$t->nama."</strong> berhasil Dihapus!");
      return redirect('/mst/kegiatan');
    }

    public function list_datatables_api()
    {
      // $data = Skpd::where('is_deleted', 0)->orderBy('nama', 'ASC')->get();
      $data = DB::table('mst_kegiatan AS k')
      ->select(DB::raw('k.id, k.nama, skpd.name AS nama_skpd'))
      ->join('mst_skpd AS skpd', function($join) {
        $join->on('skpd.id', '=', 'k.id_skpd');
        $join->where('skpd.is_deleted', 0);
      })
      ->where('k.is_deleted', 0);

      return Datatables::of($data)->make(true);
    }

    public function get_kegiatan_by_id(Request $request)
    {
      $id = $request->input('id');
      $data = Kegiatan::where("is_deleted", 0)->where("id", $id)->first();

      return response()->json($data);
    }

    public function get_kegiatan_by_id_skpd(Request $request)
    {  
      $id_skpd = $request->input('id') > 0 ? $request->input('id') : 0;
      $data = Kegiatan::where('id_skpd', $id_skpd)
      ->where('is_deleted', 0)
      ->orderBy('id', 'ASC')
      ->get();

      return response()->json($data);
    }

}