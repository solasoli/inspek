<?php

namespace App\Http\Controllers\Laporan;

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
use App\SuratPerintahSasaran;
use App\Skpd;
use App\Wilayah;
use App\Sasaran;
use App\DasarSurat;
use App\Periode;
use App\Model\Pegawai\Pegawai;
use App\Model\Pegawai\Peran;
use App\Kegiatan;
use App\Service\KegiatanService;
use App\Service\PegawaiService;
use App\Service\SuratPerintahService;

date_default_timezone_set('Asia/Jakarta');

class LhpController extends Controller
{
    public function index()
    {
      return view('laporan.lhp-list');
    }

    public function create($type)
    {
      $wilayah = Wilayah::where("is_deleted", 0)->orderBy('nama')->get();
      
      $periode = Periode::where("is_deleted", 0)->get();
      $kegiatan = Kegiatan::where("is_deleted", 0)->where("type_pkpt", 1)->get();
      $list_inspektur = $this->get_current_inspektur(0);

      $dasar_surat = DasarSurat::first();
      $surat_perintah_file = $type == 1 ? 'surat_perintah_pkpt-form' : ($type == 2 ? 'surat_perintah_non_pkpt-form' : 'surat_perintah_khusus-form');

      return view('pkpt.'. $surat_perintah_file,[
        'kegiatan' => $kegiatan,
        'wilayah' => $wilayah,
        'dasar_surat' => $dasar_surat,
        'periode' => $periode,
        'list_inspektur' => $list_inspektur,
        'type' => $type
      ]);
    }

    public function store(Request $request, $type)
    {

      $logged_user = Auth::user();

      SuratPerintahService::create($request->input(), $type);

      $request->session()->flash('message', "Data Berhasil disimpan!");
      return redirect('/pkpt/surat_perintah');
    }

    public function edit($id)
    {
      $surat_perintah = SuratPerintah::findOrFail($id);

      $wilayah = Wilayah::where("is_deleted", 0)->orderBy('nama')->get();
      $periode = Periode::where("is_deleted", 0)->get();
      $kegiatan = Kegiatan::where("is_deleted", 0)->where("type_pkpt", 1)->get();
      $list_inspektur = $this->get_current_inspektur(0);

      $type = $surat_perintah->is_pkpt;

      $dasar_surat = DasarSurat::first();

      $sp_sasaran = SuratPerintahService::get_sasaran($surat_perintah->id);
      $sp_anggota = SuratPerintahService::get_anggota($surat_perintah->id);

      $current_kegiatan = Kegiatan::where("id", $surat_perintah->id_kegiatan)->first();
      $anggota = PegawaiService::get_anggota(false, $current_kegiatan->id_wilayah);

      $surat_perintah_file = $surat_perintah->is_pkpt == 1 ? 'surat_perintah_pkpt-form' : ($surat_perintah->is_pkpt == 2 ? 'surat_perintah_non_pkpt-form' : 'surat_perintah_khusus-form');


      return view('pkpt.'.$surat_perintah_file,[
        'data' => $surat_perintah,
        'kegiatan' => $kegiatan,
        'wilayah' => $wilayah,
        'dasar_surat' => $dasar_surat,
        'periode' => $periode,
        'list_inspektur' => $list_inspektur,
        'type' => $type,
        'sp_sasaran' => $sp_sasaran,
        'sp_anggota' => $sp_anggota,
        'anggota' => $anggota,
        'current_kegiatan' => $current_kegiatan,
      ]);

    }

    public function update(Request $request, $id)
    {
      SuratPerintahService::update($id, $request->input());

      $request->session()->flash('message', "Data berhasil Dirubah!");
      return redirect('/pkpt/surat_perintah');
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
          pkt.nama AS nama_ketua_tim, pktj.name AS ketua_tim_jabatan"))
      ->join("mst_wilayah AS w", "w.id", "=", "sp.id_wilayah")
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

      $anggota = SuratPerintahService::get_anggota($id);
      $sasaran = SuratPerintahService::get_sasaran($id);

      return view('pkpt.surat_perintah-detail', [
        'data' => $data_sp,
        'anggota' => $anggota,
        'sasaran' => $sasaran
      ]);
    }


    public function kalendar()
    {
      $data = DB::table('pkpt_surat_perintah AS sp')
      ->select(DB::raw("sp.id, sp.dari, sp.sampai, sp.is_pkpt, k.nama AS nama_kegiatan"))
      ->join('mst_kegiatan AS k', 'k.id','=','sp.id_kegiatan')
      ->where("sp.is_deleted", 0)
      ->get();
      return view('pkpt.surat_perintah-kalendar', [
        'data' => $data
      ]);
    }

    public function list_datatables_api($type = 1)
    {
      $data = DB::table("pkpt_surat_perintah AS sp")
      ->select(DB::raw("sp.id, sp.no_surat, sp.dari, sp.sampai, sp.is_pkpt, sp.is_approve,
      w.nama AS wilayah, k.nama AS kegiatan, GROUP_CONCAT(DISTINCT s.nama ORDER BY sps.id ASC SEPARATOR '; ') AS sasaran"))
      ->join("mst_wilayah AS w", "w.id", "=", "sp.id_wilayah")
      ->join("mst_kegiatan As k", "k.id", "=", "sp.id_kegiatan")
      ->join("pkpt_surat_perintah_sasaran As sps", "sp.id", "=", "sps.id_surat_perintah")
      ->join("mst_sasaran As s", "s.id", "=", "sps.id_sasaran")
      ->where('sp.is_deleted', 0)
      ->where('sps.is_deleted', 0)
      ->where('w.is_deleted', 0)
      ->where('k.is_deleted', 0)
      ->where("sp.is_pkpt", $type)
      ->groupBy(['sp.id', 'sp.no_surat', 'sp.dari', 'sp.sampai', 'sp.is_pkpt', 'sp.is_approve', 'w.nama', 'k.nama'])
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
