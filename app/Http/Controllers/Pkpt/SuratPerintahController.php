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
use App\SuratPerintahAnggota;
use App\Skpd;
use App\Wilayah;
use App\Sasaran;
use App\DasarSurat;
use App\Periode;
use App\Model\Pegawai\Pegawai;
use App\Model\Pegawai\Peran;

date_default_timezone_set('Asia/Jakarta');

class SuratPerintahController extends Controller
{
    public function index()
    {
      return view('pkpt.surat_perintah-list');
    }

    public function create($type = 1)
    {
      $wilayah = Wilayah::where("is_deleted", 0)->orderBy('nama')->get();

      // get peran anggota 
      $peran_anggota = Peran::where("is_anggota", 1)->where("is_deleted", 0)->first();

      $pegawai = Pegawai::where("is_deleted",0)->where("id_peran", $peran_anggota->id)->get();
      $sasaran = Sasaran::where("is_deleted", 0)->get();
      $periode = Periode::where("is_deleted", 0)->get();
      $list_inspektur = $this->get_current_inspektur(0);

      $dasar_surat = DasarSurat::first();
      $surat_perintah_file = $type != 2 ? 'surat_perintah-form' : 'surat_perintah_khusus-form';
      return view('pkpt.'. $surat_perintah_file,[
        'pegawai' => $pegawai,
        'wilayah' => $wilayah,
        'sasaran' => $sasaran,
        'dasar_surat' => $dasar_surat,
        'periode' => $periode,
        'list_inspektur' => $list_inspektur,
        'type' => $type
      ]);
    }

    public function store(Request $request, $type = 1)
    {
      $logged_user = Auth::user();

      $arr_validation = [
        // 'periode' => [
        //   'required'
        // ],
        
        'wilayah' => [
          $type != 2 ? 'required' : ''
        ],
        'inspektur_pembantu' => [
          'required'
        ],
        'pengendali_teknis' => [
          'required'
        ],
        'ketua_tim' => [
          'required'
        ],
        'no_surat' => [
          'required'
        ],
        'dasar_surat' => [
          'required'
        ],
        'untuk' => [
          'required'
        ],
        'dari' => [
          'required'
        ],
        'sampai' => [
          'required'
        ]
      ];

      request()->validate($arr_validation,[
        'nama.required' => 'Nama SuratPerintah harus diisi!',
        'nama.unique' => 'Nama SuratPerintah sudah ada!'
      ]);

      // get wilayah
      if($type != 2){
        $wilayah = Wilayah::findOrFail($request->input("wilayah"));
      }

      $t = new SuratPerintah;
      $t->id_periode = 0;
      $t->id_wilayah = $request->input("wilayah") == null ? 0 : $request->input('wilayah');
      $t->id_inspektur = $request->input("inspektur");
      $t->id_inspektur_pembantu = $request->input("inspektur_pembantu");
      $t->id_pengendali_teknis = $request->input("pengendali_teknis");
      $t->id_ketua_tim = $request->input("ketua_tim");
      $t->id_sasaran = $request->input("sasaran");
      $t->no_surat = $request->input("no_surat");
      $t->dasar_surat = $request->input("dasar_surat");
      $t->untuk = $request->input("untuk");
      $t->dari = date("Y-m-d", strtotime($request->input("dari")));
      $t->sampai = date("Y-m-d", strtotime($request->input("sampai")));
      $t->created_at = date('Y-m-d H:i:s');
      $t->created_by = Auth::id();
      $t->updated_at = NULL;
      $t->updated_by = 0;
      $t->deleted_at = NULL;
      $t->deleted_by = 0;
      $t->is_deleted = 0;
      $t->is_pkpt = $type;
      $t->save();

      // insert anggota
      if(count($request->input("anggota")) > 0){
        foreach($request->input("anggota") as $idx => $row){
          $na = new SuratPerintahAnggota;
          $na->id_surat_perintah = $t->id;
          $na->id_anggota = $row;
          $na->save();
        }
      }

      $request->session()->flash('message', "<strong>".$request->input('nama')."</strong> Berhasil disimpan!");
      return redirect('/pkpt/surat_perintah');
    }

    public function edit($id)
    {
      $data = SuratPerintah::find($id);

      $wilayah = DB::table("mst_wilayah AS w")
      ->select(DB::raw("w.id, w.nama, p.nama AS nama_inspektur, p.id AS id_inspektur"))
      ->join("pgw_pegawai AS p", "p.id", "=", "w.id_inspektur_pembantu")
      ->where('p.is_deleted', 0)
      ->where("w.is_deleted", 0)
      ->orderBy('w.nama', 'ASC')
      ->get();

      $inspektur_wilayah = $wilayah->map(function($val, $itm){
        return $val->id_inspektur;
      });

      $peran_anggota = Peran::where("is_anggota", 1)->where("is_deleted", 0)->first();

      $pegawai = Pegawai::where("is_deleted",0)->where("id_peran", $peran_anggota->id)->get();

      $sasaran = Sasaran::where("is_deleted", 0)->get();
      $dasar_surat = DasarSurat::first();
      $anggota = SuratPerintahAnggota::where("is_deleted", 0)->where("id_surat_perintah", $id)->get();
      $periode = Periode::where("is_deleted", 0)->get();
      $list_inspektur = $this->get_current_inspektur($id);

      $surat_perintah_file = $data->is_pkpt != 2 ? 'surat_perintah-form' : 'surat_perintah_khusus-form';
      return view('pkpt.'. $surat_perintah_file, [
        'data' => $data,
        'anggota' => $anggota,
        'pegawai' => $pegawai,
        'wilayah' => $wilayah,
        'sasaran' => $sasaran,
        'inspektur' => Pegawai::where("id", $data->id_inspektur)->first(),
        'dasar_surat' => $dasar_surat,
        'periode' => $periode,
        'list_inspektur' => $list_inspektur,
        'type' => $data->is_pkpt
      ]);
    }

    public function update(Request $request, $id)
    {
      $t = SuratPerintah::findOrFail($id);
      $logged_user = Auth::user();

      $arr_validation = [
        // 'periode' => [
        //   'required'
        // ],
        
        'wilayah' => [
          $t->is_pkpt != 2 ? 'required' : ''
        ],
        'inspektur_pembantu' => [
          'required'
        ],
        'pengendali_teknis' => [
          'required'
        ],
        'ketua_tim' => [
          'required'
        ],
        'no_surat' => [
          'required'
        ],
        'dasar_surat' => [
          'required'
        ],
        'untuk' => [
          'required'
        ],
        'dari' => [
          'required'
        ],
        'sampai' => [
          'required'
        ]
      ];

      request()->validate($arr_validation,[
        'nama.required' => 'Nama SuratPerintah harus diisi!',
        'nama.unique' => 'Nama SuratPerintah sudah ada!'
      ]);

      // get wilayah
      if($t->is_pkpt != 2){
        $wilayah = Wilayah::findOrFail($request->input("wilayah"));
      }

      $t->id_periode = 0;
      $t->id_wilayah = $request->input("wilayah") == null ? 0 : $request->input('wilayah');
      $t->id_inspektur = $request->input("inspektur");
      $t->id_inspektur_pembantu = $request->input("inspektur_pembantu");
      $t->id_pengendali_teknis = $request->input("pengendali_teknis");
      $t->id_ketua_tim = $request->input("ketua_tim");
      $t->id_sasaran = $request->input("sasaran");
      $t->no_surat = $request->input("no_surat");
      $t->dasar_surat = $request->input("dasar_surat");
      $t->untuk = $request->input("untuk");
      $t->dari = date("Y-m-d", strtotime($request->input("dari")));
      $t->sampai = date("Y-m-d", strtotime($request->input("sampai")));
      $t->updated_at = date('Y-m-d H:i:s');
      $t->updated_by = Auth::id();
      $t->save();

      //remove the last wilayah opd first
      DB::update("UPDATE pkpt_surat_perintah_anggota SET is_deleted = 1 WHERE id_surat_perintah = {$t->id}");

      if(count($request->input("anggota")) > 0){
        foreach($request->input("anggota") as $idx => $row){
          if($row > 0){
            //insert into  wilayah opd
            $na = new SuratPerintahAnggota;
            $na->id_surat_perintah = $t->id;
            $na->id_anggota = $row;
            $na->save();
          }
        }
      }

      $request->session()->flash('message', "Data berhasil diubah!");
      return redirect('/pkpt/surat_perintah');
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

    public function approve(Request $request, $id)
    {
      $logged_user = Auth::user();
      $t = SuratPerintah::findOrFail($id);
      $t->is_approve = 1;
      $t->save();

      $request->session()->flash('message', "<strong>".$t->nama."</strong> berhasil diapprove!");
      return redirect('/pkpt/surat_perintah');
    }

    public function info($id)
    {
      $data = SuratPerintah::find($id);

      $data_sp = DB::table("pkpt_surat_perintah AS sp")
        ->select(DB::raw("sp.*, 
          w.nama AS nama_wilayah,
          pi.nama AS nama_inspektur, pik.name AS inspektur_pangkat, pi.nip AS nip_inspektur,
          pib.nama AS nama_inspektur_pembantu, pibj.name AS inspektur_pembantu_jabatan,
          ppt.nama AS nama_pengendali_teknis, pptj.name AS pengendali_teknis_jabatan,
          pkt.nama AS nama_ketua_tim, pktj.name AS ketua_tim_jabatan,
          s.nama AS sasaran"))
      ->join("mst_wilayah AS w", "w.id", "=", "sp.id_wilayah")
      ->join("mst_sasaran As s", "s.id", "=", "sp.id_sasaran")
      ->join("pgw_pegawai AS pi", "pi.id", "=", "sp.id_inspektur")
      ->join("pgw_pangkat AS pik", "pik.id", "=", "pi.id_pangkat")
      ->join("pgw_pegawai AS pib", "pib.id", "=", "sp.id_inspektur_pembantu")
      ->join("pgw_jabatan AS pibj", "pibj.id", "=", "pib.id_jabatan")
      ->join("pgw_pegawai AS ppt", "ppt.id", "=", "sp.id_pengendali_teknis")
      ->join("pgw_jabatan AS pptj", "pptj.id", "=", "ppt.id_jabatan")
      ->join("pgw_pegawai AS pkt", "pkt.id", "=", "sp.id_ketua_tim")
      ->join("pgw_jabatan AS pktj", "pktj.id", "=", "pkt.id_jabatan")
      ->where('sp.is_deleted', 0)
      ->where("sp.id", $id)
      ->first();

      $anggota = DB::table("pkpt_surat_perintah_anggota AS spa")
      ->join("pgw_pegawai AS p", "spa.id_anggota", "=", "p.id")
      ->where("spa.id_surat_perintah", $id)
      ->where("spa.is_deleted", 0)
      ->get();

      return view('pkpt.surat_perintah-detail', [
        'data' => $data_sp,
        'anggota' => $anggota
      ]);
    }


    public function kalendar()
    {
      $data = SuratPerintah::where("is_deleted", 0)->get();
      return view('pkpt.surat_perintah-kalendar', [
        'data' => $data
      ]);
    }

    public function list_datatables_api($type = 1)
    {
      $data = DB::table("pkpt_surat_perintah AS sp")
        ->select(DB::raw("sp.*, 
          w.nama AS nama_wilayah,
          pi.nama AS nama_inspektur, pik.name AS inspektur_pangkat, pi.nip AS nip_inspektur,
          pib.nama AS nama_inspektur_pembantu, pibj.name AS inspektur_pembantu_jabatan,
          ppt.nama AS nama_pengendali_teknis, pptj.name AS pengendali_teknis_jabatan,
          pkt.nama AS nama_ketua_tim, pktj.name AS ketua_tim_jabatan,
          s.nama AS sasaran"))
      ->leftJoin("mst_wilayah AS w", "w.id", "=", "sp.id_wilayah")
      ->join("mst_sasaran As s", "s.id", "=", "sp.id_sasaran")
      ->join("pgw_pegawai AS pi", "pi.id", "=", "sp.id_inspektur")
      ->join("pgw_pangkat AS pik", "pik.id", "=", "pi.id_pangkat")
      ->join("pgw_pegawai AS pib", "pib.id", "=", "sp.id_inspektur_pembantu")
      ->join("pgw_jabatan AS pibj", "pibj.id", "=", "pib.id_jabatan")
      ->join("pgw_pegawai AS ppt", "ppt.id", "=", "sp.id_pengendali_teknis")
      ->join("pgw_jabatan AS pptj", "pptj.id", "=", "ppt.id_jabatan")
      ->join("pgw_pegawai AS pkt", "pkt.id", "=", "sp.id_ketua_tim")
      ->join("pgw_jabatan AS pktj", "pktj.id", "=", "pkt.id_jabatan")
      ->where('sp.is_deleted', 0)
      ->where("sp.is_pkpt", $type)
      ->orderBy('sp.id', 'ASC');
      return Datatables::of($data)->make(true);
    }

    public function check_jadwal(Request $request){
      $dari = date("Y-m-d", strtotime($request->dari));
      $sampai = date("Y-m-d", strtotime($request->sampai));

      $data = DB::table("pkpt_surat_perintah as sp")
      ->where("sp.is_deleted", 0)
      ->whereRaw(DB::raw("((sp.dari BETWEEN \"{$dari}\" AND \"{$sampai}\") OR (sp.sampai BETWEEN \"{$dari}\" AND \"{$sampai}\"))"))
      ->where("sp.id_wilayah", $request->id_wilayah)
      ->where("sp.id","!=", $request->sp_id)
      ->get();

      return response()->json(["data" => $data]);
    }

    public function get_current_inspektur($id_sp) {
      $get_inspektur_from_sp = SuratPerintah::find($id_sp);

      $list_inspektur = DB::table("pgw_pegawai AS p")
      ->select(DB::raw("p.id, p.nama"))
      ->join("pgw_peran_jabatan AS ppj", "ppj.id_jabatan", "=","p.id_jabatan")
      ->join("pgw_peran AS pp", "pp.id", "=","ppj.id_peran")
      ->where("pp.kode", 'inspektur')
      ->orWhere("p.id", $get_inspektur_from_sp != null ? $get_inspektur_from_sp->id_inspektur : 0)
      ->groupBy("p.id", "p.nama")
      ->get();

      return $list_inspektur;

    }
}
