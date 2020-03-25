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
use App\Model\Pegawai\Pegawai;
use App\Skpd;
use App\Model\Pegawai\Eselon;
use App\Model\Pegawai\Pangkat;
use App\Model\Pegawai\PangkatGolongan;
use App\Model\Pegawai\Jabatan;
use App\Inspektur;
use App\Wilayah;

date_default_timezone_set('Asia/Jakarta');

class PegawaiController extends Controller
{
    public function index()
    {
      return view('mst.pegawai-list');
    }

    public function create()
    {
      $opd = Skpd::where("is_deleted", 0)->get();
      $eselon = Eselon::where("is_deleted", 0)->get();
      $pangkat = Pangkat::where("is_deleted", 0)->get();
      $pangkat_golongan = PangkatGolongan::where("is_deleted", 0)->get();
      $jabatan = Jabatan::where("is_deleted", 0)->get();
      $wilayah = Wilayah::where("is_deleted", 0)->orderBy('nama')->get();
      return view('mst.pegawai-form',[
        'opd' => $opd,
        'eselon' => $eselon,
        'pangkat' => $pangkat,
        'pangkat_golongan' => $pangkat_golongan,
        'jabatan' => $jabatan,
        'wilayah' => $wilayah,
      ]);
    }

    public function store(Request $request)
    {
      $logged_user = Auth::user();
      request()->validate([
        'opd' => 'required',
        'eselon' => 'required',
        'pangkat' => 'required',
        'pangkat_golongan' => 'required',
        'jabatan' => 'required',
        'nip' => ['required',
          Rule::unique('pgw_pegawai', 'nip')->where(function ($query){
            return $query->where('is_deleted', 0);
          })
        ],
        'nama' => 'required',
        'nama_asli' => 'required',
        'jenjab' => 'required',
        'score_angka_credit' => 'required'
      ],[
        'opd.required' => 'OPD harus diisi!',
        'eselon.required' => 'Eselon harus diisi!',
        'pangkat.required' => 'Pangkat harus diisi!',
        'pangkat_golongan.required' => 'Pangkat Golongan harus diisi!',
        'jabatan.required' => 'Jabatan harus diisi!',
        'nip.required' => 'NIP harus diisi!',
        'nip.unique' => 'NIP sudah tersedia!',
        'nama.required' => 'Nama harus diisi!',
        'nama_asli.required' => 'Nama Asli harus diisi!',
        'jenjab.required' => 'Jenjang Jabatan harus diisi!',
        'score_angka_credit.required' => 'Score Angka Credit harus diisi!',
      ]);

      $t = new Pegawai;
      $t->id_skpd = $request->input('opd');
      $t->id_eselon = $request->input('eselon');
      $t->id_pangkat = $request->input('pangkat');
      $t->id_pangkat_golongan = $request->input('pangkat_golongan');
      $t->id_jabatan = $request->input('jabatan');
      $t->id_peran = $request->input('peran');
      $t->id_wilayah = $request->input('wilayah');
      $t->nip = $request->input('nip');
      $t->nama = $request->input('nama');
      $t->nama_asli = $request->input('nama_asli');
      $t->jenjab = $request->input('jenjab');
      $t->score_angka_credit = $request->input('score_angka_credit');
      $t->is_deleted = 0;
      $t->save();

      $request->session()->flash('message', "<strong>".$request->input('nama')."</strong> Berhasil disimpan!");
      return redirect('/mst/pegawai');
    }

    public function edit($id)
    {
      $data = Pegawai::find($id);


      $opd = Skpd::where("is_deleted", 0)->get();
      $eselon = Eselon::where("is_deleted", 0)->get();
      $pangkat = Pangkat::where("is_deleted", 0)->get();
      $pangkat_golongan = PangkatGolongan::where("is_deleted", 0)->get();
      $jabatan = Jabatan::where("is_deleted", 0)->get();
      $wilayah = Wilayah::where("is_deleted", 0)->orderBy('nama')->get();
      return view('mst.pegawai-form', ['data' => $data,

        'opd' => $opd,
        'eselon' => $eselon,
        'pangkat' => $pangkat,
        'pangkat_golongan' => $pangkat_golongan,
        'jabatan' => $jabatan,
        'wilayah' => $wilayah
      ]);
    }

    public function update(Request $request, $id)
    {
      $logged_user = Auth::user();
      request()->validate([
        'opd' => 'required',
        'eselon' => 'required',
        'pangkat' => 'required',
        'pangkat_golongan' => 'required',
        'jabatan' => 'required',
        'nip' => ['required',
          Rule::unique('pgw_pegawai', 'nip')->where(function ($query) use($id) {
            return $query->where('is_deleted', 0)
            ->where("id" ,"!=", $id);
          })
        ],
        'nama' => 'required',
        'nama_asli' => 'required',
        'jenjab' => 'required',
        'score_angka_credit' => 'required'
      ],[
        'opd.required' => 'OPD harus diisi!',
        'eselon.required' => 'Eselon harus diisi!',
        'pangkat.required' => 'Pangkat harus diisi!',
        'pangkat_golongan.required' => 'Pangkat Golongan harus diisi!',
        'jabatan.required' => 'Jabatan harus diisi!',
        'nip.required' => 'NIP harus diisi!',
        'nip.unique' => 'NIP sudah tersedia!',
        'nama.required' => 'Nama harus diisi!',
        'nama_asli.required' => 'Nama Asli harus diisi!',
        'jenjab.required' => 'Jenjang Jabatan harus diisi!',
        'score_angka_credit.required' => 'Score Angka Credit harus diisi!',
      ]);

      $t = Pegawai::findOrFail($id);
      $t->id_skpd = $request->input('opd');
      $t->id_eselon = $request->input('eselon');
      $t->id_pangkat = $request->input('pangkat');
      $t->id_pangkat_golongan = $request->input('pangkat_golongan');
      $t->id_jabatan = $request->input('jabatan');
      $t->id_peran = $request->input('peran');
      $t->id_wilayah = $request->input('wilayah');
      $t->nip = $request->input('nip');
      $t->nama = $request->input('nama');
      $t->nama_asli = $request->input('nama_asli');
      $t->jenjab = $request->input('jenjab');
      $t->score_angka_credit = $request->input('score_angka_credit');
      $t->save();

      $request->session()->flash('message', "Data berhasil diubah!");
      return redirect('/mst/pegawai');
    }

    public function destroy(Request $request, $id)
    {
      $logged_user = Auth::user();
      $t = Pegawai::findOrFail($id);
      $t->deleted_at = date('Y-m-d H:i:s');
      $t->deleted_by = Auth::id();
      $t->is_deleted = 1;
      $t->save();

      $request->session()->flash('message', "<strong>".$t->name."</strong> berhasil Dihapus!");
      return redirect('/mst/pegawai');
    }

    public function list_datatables_api()
    {
      $data = DB::table("pgw_pegawai AS p")
      ->select(DB::raw("p.*, skpd.name AS opd, e.name AS eselon, pk.name AS pangkat, pg.name AS pangkat_golongan, j.name AS jabatan"))
      ->join("mst_skpd AS skpd" , "p.id_skpd", "=", "skpd.id")
      ->join("pgw_eselon AS e", "p.id_eselon", "=", "e.id")
      ->join("pgw_pangkat AS pk", "p.id_pangkat", "=", "pk.id")
      ->join("pgw_pangkat_golongan AS pg", "p.id_pangkat_golongan", "=", "pg.id")
      ->join("pgw_jabatan AS j", "p.id_jabatan", "=", "j.id")
      ->where('p.is_deleted', 0);
      return Datatables::of($data)->make(true);
    }

    public function inspektur(){

      $pegawai = Pegawai::where("is_deleted",0)->get();
      $current_inspektur = $this->get_current_inspektur(true);
      return view('mst.inspektur-form', [
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

      $request->session()->flash('message', "<strong>".$request->input('nama')."</strong> Berhasil disimpan!");
      return redirect('/mst/pegawai/inspektur');

    }

    public function get_current_inspektur($return_object = false){
      $inspektur = Inspektur::where("is_current_inspektur", 1)->first();

      if($return_object){
        return $inspektur;
      }
      else{
        return response()->json(['data' => $inspektur]);
      }

    }


    public function get_pengendali_teknis_by_wilayah(Request $request)
    {
      $id_wilayah = $request->input("id_wilayah") > 0 ? $request->input("id_wilayah") : 0; 
      $data = DB::table("mst_wilayah AS w")
      ->select(DB::raw("w.id, w.nama, p.nama AS nama_inspektur, p.id AS id_inspektur"))
      ->join("pgw_pegawai AS p", "p.id_wilayah", "=", "w.id")
      ->join('pgw_peran AS pp', 'pp.id', '=', 'p.id_peran')
      ->where('p.is_deleted', 0)
      ->whereIn("pp.kode", ['pengendali_mutu', 'pengendali_teknis'])
      ->where("w.is_deleted", 0);

      if($request->input('id_wilayah') != 'all') {
        $data = $data->where("w.id", $id_wilayah);
      }
      
      $data = $data->orderBy('w.nama', 'ASC')
      ->get();
      return response()->json(["data" => $data]);
    }

    public function get_ketua_tim_by_wilayah(Request $request)
    {
      $id_wilayah = $request->input("id_wilayah") > 0 ? $request->input("id_wilayah") : 0; 
      $data = DB::table("mst_wilayah AS w")
      ->select(DB::raw("w.id, w.nama, p.nama AS nama_inspektur, p.id AS id_inspektur"))
      ->join("pgw_pegawai AS p", "p.id_wilayah", "=", "w.id")
      ->join('pgw_peran AS pp', 'pp.id', '=', 'p.id_peran')
      ->where('p.is_deleted', 0)
      ->where("pp.kode", 'ketua_tim')
      ->where("w.is_deleted", 0);

      if($request->input('id_wilayah') != 'all') {
        $data = $data->where("w.id", $id_wilayah);
      }
      
      $data = $data->orderBy('w.nama', 'ASC')
      ->get();
      return response()->json(["data" => $data]);
    }
}
