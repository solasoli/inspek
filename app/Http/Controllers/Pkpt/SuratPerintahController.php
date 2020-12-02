<?php

namespace App\Http\Controllers\Pkpt;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Datatables;
use Auth;
use Illuminate\Support\Facades\DB;
use App\Repository\SuratPerintah\SuratPerintah;
use App\Repository\Master\Skpd;
use App\Wilayah;
use App\DasarSurat;
use App\Periode;
use App\Service\Master\KegiatanService;
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
    $kegiatan = KegiatanService::get_data();
    $anggota = PegawaiService::get_anggota(false, $surat_perintah->program_kerja->id_wilayah);
    $data = SuratPerintahService::data_for_form(['data' => $surat_perintah, 'anggota' => $anggota, 'kegiatan' => $kegiatan]);

    $surat_perintah_file = $surat_perintah->is_pkpt == 1 ? 'surat_perintah_pkpt-form' : ($surat_perintah->is_pkpt == 2 ? 'surat_perintah_non_pkpt-form' : 'surat_perintah_khusus-form');

    return view('pkpt.' . $surat_perintah_file, $data);
  }

  public function update(Request $request, $id)
  {
    SuratPerintahService::update($id, $request->input());
    $request->session()->flash('message', "Data berhasil Dirubah!");
    return redirect('/pkpt/surat_perintah');
  }

  public function destroy(Request $request, $id)
  {
    SuratPerintahService::delete($id);

    $request->session()->flash('message', "Data berhasil Dihapus!");
    return redirect('/pkpt/surat_perintah');
  }

  public function approve(Request $request, $id)
  {
    $t = SuratPerintahService::approve($id);

    $request->session()->flash('message', "Berhasil diapprove!");
    return redirect('/pkpt/surat_perintah');
  }

  public function info($id)
  {
    $data = SuratPerintah::findOrFail($id);
    $skpd = Skpd::findOrFail($data->program_kerja->id_skpd);

    return view('pkpt.surat_perintah-detail', [
      'data' => $data,
      'skpd' => $skpd
    ]);
  }


  public function kalendar()
  {
    $listcolor = [
      1 => [
        'bgColor' => '#3788d8',
        'borderColor' => '#3788d8',
        'textColor' => '#fff',
        'label' => 'PKPT'
      ],
      2 => [
        'bgColor' => '#f8d7da',
        'borderColor' => '#f5c6cb',
        'textColor' => '#721c24',
        'label' => 'NON-PKPT'
      ],
      // 3 => [
      // 'bgColor' => '#4b476d',
      // 'borderColor' => '#4b476d',
      // 'textColor' => '',
      // 'label' => 'KHUSUS'
      // ]
    ];
    return view('pkpt.surat_perintah-kalendar', [
      'listcolor' => $listcolor
    ]);
  }

  public function list_datatables_api($type = null)
  {
    $data = SuratPerintah::with(['wilayah', 'program_kerja', 'sasaran']);
    if ($type > 0) {
      $data = $data->where("sp.is_pkpt", $type);
    }

    return Datatables::eloquent($data)->toJson();
  }

  public function list_datatables_approve_api($approved = 0)
  {
    $data = SuratPerintah::with(['wilayah', 'program_kerja', 'sasaran', 'kegiatan'])->where('is_approve', $approved);

    return Datatables::eloquent($data)->toJson();
  }

  public function list_datatables_peNomoran_api($is_avail_no = 0)
  {
    $data = SuratPerintah::with(['wilayah', 'program_kerja', 'sasaran', 'kegiatan'])->where('is_approve', 1);

    if ($is_avail_no == 1) {
      $data = $data->whereRaw(DB::raw("TRIM(no_surat) != ''"));
    } else {
      $data = $data->whereRaw(DB::raw("TRIM(no_surat) = ''"));
    }
    return Datatables::of($data->get())->toJson();
  }

  public function list_datatables_penomeran_lhp_api($is_avail_no = 0)
  {
    $data = SuratPerintah::with(['wilayah', 'program_kerja', 'sasaran', 'kegiatan'])->where('is_approve', 1)
    ->where('id_status_sp', 7);

    if ($is_avail_no == 1) {
      $data = $data->whereRaw(DB::raw("(TRIM(no_lhp) != '' AND no_lhp IS NOT null)"));
    } else {
      $data = $data->whereRaw(DB::raw("(TRIM(no_lhp) = '' OR no_lhp IS null)"));
    }
    return Datatables::of($data->get())->toJson();
  }

  public function check_jadwal(Request $request)
  {
    $dari = date("Y-m-d", strtotime($request->dari));
    $sampai = date("Y-m-d", strtotime($request->sampai));

    $data = SuratPerintah::whereRaw(DB::raw("((dari BETWEEN \"{$dari}\" AND \"{$sampai}\") OR (sampai BETWEEN \"{$dari}\" AND \"{$sampai}\"))"))
      ->where("id_wilayah", $request->id_wilayah)
      ->where("id", "!=", $request->sp_id)
      ->get();

    $message = $data->count() > 0 ? get_constant('JADWAL_AVAILABLE_TANGGAL_MSG') : '';

    return response()->json(["msg" => $message, 'show_warning' => $data->count() > 0 ? 1 : 0]);
  }

  public function check_jadwal_by_id_kegiatan(Request $request)
  {
    $id_kegiatan = $request->kegiatan > 0 ? $request->kegiatan : 0;
    $sp_id = $request->sp_id > 0 ? $request->sp_id : 0;

    $data = SuratPerintah::where("is_deleted", 0)
      ->where("id_kegiatan", $id_kegiatan)
      ->where("id", "!=", $sp_id)
      ->get();

    $message = $data->count() > 0 ? get_constant('JADWAL_AVAILABLE_KEGIATAN_MSG') : '';

    return response()->json(["msg" => $message, 'show_warning' => $data->count() > 0 ? 1 : 0]);
  }

  public function penomoran_surat()
  {
    return view('pkpt.penomoran_surat-list');
  }

  public function penomoran_lhp()
  {
    return view('pkpt.penomoran_lhp-list');
  }

  public function get_event_sp(Request $request)
  {
    $dari = date("Y-m-d", strtotime($request->start));
    $sampai = date("Y-m-d", strtotime($request->end));

    $data = SuratPerintah::whereRaw(DB::raw("((dari BETWEEN \"{$dari}\" AND \"{$sampai}\") OR (sampai BETWEEN \"{$dari}\" AND \"{$sampai}\"))"))
    ->where('is_approve', 1)
    ->get();

    $list_arr = [];
    $listcolor = [
      1 => [
        'bgColor' => '#3788d8',
        'borderColor' => '#3788d8',
        'textColor' => '#fff',
        'label' => 'PKPT'
      ],
      2 => [
        'bgColor' => '#f8d7da',
        'borderColor' => '#f5c6cb',
        'textColor' => '#721c24',
        'label' => 'NON-PKPT'
      ],
      // 3 => [
      // 'bgColor' => '#4b476d',
      // 'borderColor' => '#4b476d',
      // 'textColor' => '',
      // 'label' => 'KHUSUS'
      // ]
    ];
    foreach ($data as $idx => $row) {


      $list_arr[] = [
        "title" => $row->program_kerja->sub_kegiatan,
        "start" => $row->dari,
        // "daysOfWeek" =>  [ '3' ],
        "end" => date("Y-m-d 23:59:59", strtotime($row->sampai)),
        "url" => "/pkpt/surat_perintah/info/" . $row->id,
        "backgroundColor" => $listcolor[$row->is_pkpt]['bgColor'],
        "borderColor" => $listcolor[$row->is_pkpt]['borderColor'],
        "textColor" => $listcolor[$row->is_pkpt]['textColor']
      ];
    }

    return json_encode($list_arr);
  }

  public function rubah_Nomor(Request $request)
  {

    $id = $request->id;
    $logged_user = Auth::user();

    $t = SuratPerintah::findOrFail($id);
    $t->no_surat = $request->no_surat;
    $t->save();

    $request->session()->flash('success', "Berhasil merubah data!");
    return redirect('/pkpt/surat_perintah/Nomor');
  }

  public function rubah_nomer_lhp(Request $request)
  {

    $id = $request->id;
    $logged_user = Auth::user();

    $t = SuratPerintah::findOrFail($id);
    $t->no_lhp = $request->no_surat;
    $t->save();

    $request->session()->flash('success', "Berhasil merubah data!");
    return redirect('/pemeriksaan/laporan_lhp/penomeran_lhp');
  }
}
