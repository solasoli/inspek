<?php

namespace App\Http\Controllers\Pkpt;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Datatables;
use Auth;
use Illuminate\Support\Facades\DB;
use App\Repository\SuratPerintah\SuratPerintah;
use App\Wilayah;
use App\DasarSurat;
use App\Periode;
use App\Service\Pegawai\PegawaiService;
use App\Service\ProgramKerjaService;
use App\Service\SuratPerintah\SuratPerintahService;

date_default_timezone_set('Asia/Jakarta');

class SuratPerintahController extends Controller
{
  public function index()
  {
    return view('pkpt.surat_perintah-list');
  }

  public function create($type)
  {

    $data = SuratPerintahService::data_for_form();
    $surat_perintah_file = $type == 1 ? 'surat_perintah_pkpt-form' : ($type == 2 ? 'surat_perintah_non_pkpt-form' : 'surat_perintah_khusus-form');

    return view('pkpt.' . $surat_perintah_file, $data);
  }

  public function store(Request $request, $type)
  {
    SuratPerintahService::create($request->input(), $type);

    $request->session()->flash('message', "Data Berhasil disimpan!");
    return redirect('/pkpt/surat_perintah');
  }

  public function edit($id)
  {
    $surat_perintah = SuratPerintah::findOrFail($id);    
    $anggota = PegawaiService::get_anggota(false, $surat_perintah->program_kerja->id_wilayah);
    $data = SuratPerintahService::data_for_form(['data' => $surat_perintah, 'anggota' => $anggota]);

    $surat_perintah_file = $surat_perintah->is_pkpt == 1 ? 'surat_perintah_pkpt-form' : ($surat_perintah->is_pkpt == 2 ? 'surat_perintah_non_pkpt-form' : 'surat_perintah_khusus-form');

    // 'program_kerja' => $program_kerja,
    // 'wilayah' => $wilayah,
    // 'dasar_surat' => $dasar_surat,
    // 'periode' => $periode,
    // 'list_inspektur' => $list_inspektur,

    return view('pkpt.' . $surat_perintah_file, $data);
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

    $request->session()->flash('message', "<strong>" . $t->nama . "</strong> berhasil diapprove!");
    return redirect('/pkpt/surat_perintah');
  }

  public function info($id)
  {
    $data = SuratPerintah::find($id);

    return view('pkpt.surat_perintah-detail', [
      'data' => $data
    ]);
  }


  public function kalendar()
  {
    $data = DB::table('pkpt_surat_perintah AS sp')
      ->select(DB::raw("sp.id, sp.dari, sp.sampai, sp.is_pkpt, pk.sub_kegiatan AS nama_kegiatan"))
      ->join('mst_program_kerja AS pk', 'pk.id', '=', 'sp.id_program_kerja')
      ->where("sp.is_deleted", 0)
      ->get();
    return view('pkpt.surat_perintah-kalendar', [
      'data' => $data
    ]);
  }

  public function list_datatables_api($type = null)
  {
    $data = DB::table("pkpt_surat_perintah AS sp")
      ->select(DB::raw("sp.id, sp.no_surat, sp.dari, sp.sampai, sp.is_pkpt, sp.is_approve,
      w.nama AS wilayah, pk.sub_kegiatan AS kegiatan, GROUP_CONCAT(DISTINCT s.nama ORDER BY sps.id ASC SEPARATOR '; ') AS sasaran"))
      ->join("mst_wilayah AS w", "w.id", "=", "sp.id_wilayah")
      ->join("mst_program_kerja As pk", "pk.id", "=", "sp.id_program_kerja")
      ->join("pkpt_surat_perintah_sasaran As sps", "sp.id", "=", "sps.id_surat_perintah")
      ->join("mst_sasaran As s", "s.id", "=", "sps.id_sasaran")
      ->where('sp.is_deleted', 0)
      ->where('sps.is_deleted', 0)
      ->where('w.is_deleted', 0)
      ->where('pk.is_deleted', 0)
      ->groupBy(['sp.id', 'sp.no_surat', 'sp.dari', 'sp.sampai', 'sp.is_pkpt', 'sp.is_approve', 'w.nama', 'pk.sub_kegiatan'])
      ->orderBy('sp.id', 'ASC');
    if ($type > 0) {
      $data = $data->where("sp.is_pkpt", $type);
    }

    return Datatables::of($data)->make(true);
  }

  public function list_datatables_approve_api($approved = 0)
  {
    $data = DB::table("pkpt_surat_perintah AS sp")
      ->select(DB::raw("sp.id, sp.no_surat, sp.dari, sp.sampai, sp.is_pkpt, sp.is_approve,
      w.nama AS wilayah, pk.sub_kegiatan AS kegiatan, GROUP_CONCAT(DISTINCT s.nama ORDER BY sps.id ASC SEPARATOR '; ') AS sasaran"))
      ->join("mst_wilayah AS w", "w.id", "=", "sp.id_wilayah")
      ->join("mst_program_kerja As pk", "pk.id", "=", "sp.id_program_kerja")
      ->join("pkpt_surat_perintah_sasaran As sps", "sp.id", "=", "sps.id_surat_perintah")
      ->join("mst_sasaran As s", "s.id", "=", "sps.id_sasaran")
      ->where('sp.is_deleted', 0)
      ->where('sps.is_deleted', 0)
      ->where('w.is_deleted', 0)
      ->where('pk.is_deleted', 0)
      ->where("sp.is_approve", $approved)
      ->groupBy(['sp.id', 'sp.no_surat', 'sp.dari', 'sp.sampai', 'sp.is_pkpt', 'sp.is_approve', 'w.nama', 'pk.sub_kegiatan'])
      ->orderBy('sp.id', 'ASC');

    return Datatables::of($data)->make(true);
  }

  public function list_datatables_penomeran_api($is_avail_no = 0)
  {
    $data = DB::table("pkpt_surat_perintah AS sp")
      ->select(DB::raw("sp.id, sp.no_surat, sp.dari, sp.sampai, sp.is_pkpt, sp.is_approve,
      w.nama AS wilayah, pk.sub_kegiatan AS kegiatan, GROUP_CONCAT(DISTINCT s.nama ORDER BY sps.id ASC SEPARATOR '; ') AS sasaran"))
      ->join("mst_wilayah AS w", "w.id", "=", "sp.id_wilayah")
      ->join("mst_program_kerja As pk", "pk.id", "=", "sp.id_program_kerja")
      ->join("pkpt_surat_perintah_sasaran As sps", "sp.id", "=", "sps.id_surat_perintah")
      ->join("mst_sasaran As s", "s.id", "=", "sps.id_sasaran")
      ->where('sp.is_deleted', 0)
      ->where('sps.is_deleted', 0)
      ->where('w.is_deleted', 0)
      ->where('pk.is_deleted', 0)
      ->groupBy(['sp.id', 'sp.no_surat', 'sp.dari', 'sp.sampai', 'sp.is_pkpt', 'sp.is_approve', 'w.nama', 'pk.sub_kegiatan'])
      ->orderBy('sp.id', 'ASC');
    if ($is_avail_no == 1) {
      $data = $data->whereRaw(DB::raw("TRIM(sp.no_surat) != ''"));
    } else {
      $data = $data->whereRaw(DB::raw("TRIM(sp.no_surat) = ''"));
    }

    return Datatables::of($data)->make(true);
  }

  public function check_jadwal(Request $request)
  {
    $dari = date("Y-m-d", strtotime($request->dari));
    $sampai = date("Y-m-d", strtotime($request->sampai));

    $data = DB::table("pkpt_surat_perintah as sp")
      ->where("sp.is_deleted", 0)
      ->whereRaw(DB::raw("((sp.dari BETWEEN \"{$dari}\" AND \"{$sampai}\") OR (sp.sampai BETWEEN \"{$dari}\" AND \"{$sampai}\"))"))
      ->where("sp.id_wilayah", $request->id_wilayah)
      ->where("sp.id", "!=", $request->sp_id)
      ->get();

    $message = $data->count() > 0 ? get_constant('JADWAL_AVAILABLE_TANGGAL_MSG') : '';

    return response()->json(["msg" => $message, 'show_warning' => $data->count() > 0 ? 1 : 0]);
  }

  public function check_jadwal_by_id_kegiatan(Request $request)
  {
    $id_kegiatan = $request->kegiatan > 0 ? $request->kegiatan : 0;
    $sp_id = $request->sp_id > 0 ? $request->sp_id : 0;

    $data = DB::table("pkpt_surat_perintah as sp")
      ->where("sp.is_deleted", 0)
      ->where("sp.id_kegiatan", $id_kegiatan)
      ->where("sp.id", "!=", $sp_id)
      ->get();

    $message = $data->count() > 0 ? get_constant('JADWAL_AVAILABLE_KEGIATAN_MSG') : '';

    return response()->json(["msg" => $message, 'show_warning' => $data->count() > 0 ? 1 : 0]);
  }


  public function penomeran_surat()
  {

    return view('pkpt.penomeran_surat-list');
  }

  public function rubah_nomer(Request $request)
  {

    $id = $request->id;
    $logged_user = Auth::user();
    $t = SuratPerintah::findOrFail($id);
    $t->no_surat = $request->no_surat;
    $t->save();

    $request->session()->flash('success', "Berhasil merubah data!");
    return redirect('/pkpt/surat_perintah/nomer');
  }
}
