<?php

namespace App\Http\Controllers\Pkpt;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Datatables;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Repository\SuratPerintah\SuratPerintah;
use App\Repository\Master\Skpd;
use App\Wilayah;
use App\DasarSurat;
use App\Periode;
use App\Repository\AngkaKredit\SubUnsur;
use App\Service\Master\KegiatanService;
use App\Service\Pegawai\PegawaiService;
use App\Service\ProgramKerjaService;
use App\Service\SuratPerintah\SuratPerintahService;
use App\Export\SuratPerintahExport;
use App\Export\SuratPerintahNomorExport;
use App\Repository\SuratPerintah\TypePkpt;
use Maatwebsite\Excel\Facades\Excel;
use View;

date_default_timezone_set('Asia/Jakarta');

class SuratPerintahController extends Controller
{
  public function index()
  {
    $type_pkpt = TypePkpt::where('is_deleted', 0)->get();
    return view('pkpt.surat_perintah-list', [
      'type_pkpt' => $type_pkpt
    ]);
  }

  public function create($type)
  {
    $get_file = $this->get_file_sp($type);
    $data = SuratPerintahService::data_for_form(['multiple_pkpt' => $get_file->multiple_pkpt]);
    return view('pkpt.' . $get_file->surat_perintah_file, $data);
  }

  public function lampiran()
  {
    return view('pkpt.preview_lampiran');
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
    $anggota = [];
    if($surat_perintah->program_kerja != null) {
      $anggota = PegawaiService::get_anggota(false, $surat_perintah->program_kerja->id_wilayah);
    }
    $get_file = $this->get_file_sp($surat_perintah->is_pkpt);
    $data = SuratPerintahService::data_for_form(['data' => $surat_perintah, 'anggota' => $anggota, 'kegiatan' => $kegiatan, 'multiple_pkpt' => $get_file->multiple_pkpt]);
    return view('pkpt.' . $get_file->surat_perintah_file, $data);
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
    $skpd = $data->skpd;

    return view('pkpt.surat_perintah-detail', [
      'data' => $data,
      'skpd' => $skpd
    ]);
  }

  public function info_is_lampiran($id)
  {
    $data = SuratPerintah::findOrFail($id);
    $skpd = $data->skpd;

    // return $data;
    return view('pkpt.surat_perintah-detail-lampiran', [
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

  public function list_datatables_penomeran_api($is_avail_no = 0)
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

  public function penomeran_surat()
  {
    return view('pkpt.penomeran_surat-list');
  }

  public function penomeran_surat_print($method = 'html', $is_avail_no = 0)
  {
    $label = $is_avail_no == 0 ? 'Belum Memiliki Nomor' : 'Sudah Memiliki Nomor';
    if($method == 'html') {
      $data = SuratPerintah::with(['wilayah', 'program_kerja', 'sasaran', 'kegiatan'])->where('is_approve', 1);
  
      if ($is_avail_no == 1) {
        $data = $data->whereRaw(DB::raw("TRIM(no_surat) != ''"));
      } else {
        $data = $data->whereRaw(DB::raw("TRIM(no_surat) = ''"));
      }
      
      $data = $data->get();
      return view('pkpt.penomeran_surat-print', [
        'data' => $data,
        'is_avail_no' => $is_avail_no
      ]);
    } else if($method == 'excel') {
      return Excel::download(new SuratPerintahNomorExport($is_avail_no), "Surat Perintah Nomor - {$label}.xlsx");
    } else if($method == 'pdf') {
      return Excel::download(new SuratPerintahNomorExport($is_avail_no), "Surat Perintah Nomor - {$label}.pdf");
    }
  }

  public function penomeran_lhp()
  {
    return view('pkpt.penomeran_lhp-list');
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
        "title" => $row->kegiatan->nama,
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
  
  public function get_sub_unsur($id_unsur = 0) {
    $tipe_auditor = 1;
    $sub_unsur = SubUnsur::where('is_deleted', 0)
    ->where('id_unsur', $id_unsur)
    ->where('id_tipe_auditor', $tipe_auditor)
    ->get();

    return response()->json(['data' => $sub_unsur]);
  }

  public function get_butir_kegiatan($id_sub_unsur = 0) {
      $sub_unsur = SubUnsur::findOrFail($id_sub_unsur);

      return response()->json(['data' => $sub_unsur->butir_kegiatan()->with('satuan')->get()]);
  }
  public function print($id, $method = 'html')
  {
    $data = SuratPerintah::findOrFail($id);
    if($method == 'html') {
      return view('Mst.program_kerja-print', [
        'data' => $data
      ]);
    } else if($method == 'pdf') {
      return Excel::download(new SuratPerintahExport($data), "Surat Perintah - {$data->nomor}.pdf");
    } else if($method == 'word') { 
      $skpd = Skpd::findOrFail($data->program_kerja->id_skpd);
      // Creating the new document...
      $phpWord = new \PhpOffice\PhpWord\PhpWord();

      /* Note: any element you append to a document must reside inside of a Section. */

      // Adding an empty Section to the document...
      $section = $phpWord->addSection();

      // Adding Text element to the Section having font styled by default...
      $view_content = View::make('pkpt.surat_perintah-word', ['data' => $data, 'skpd' => $skpd])->render();
      // $view_content = $this->_parseHtml($view_content);


      \PhpOffice\PhpWord\Shared\Html::addHtml($section, $view_content, true);
      // $section->addHtml($section, $view_content['htmlBody']);
      // $section->addText('naha ai sia goblog');

      // Saving the document as HTML file...
      $file_name = "Surat Perintah - {$data->nomor}.docx";
      header('Content-Type: application/octet-stream');
      header('Content-Disposition: attachment;filename="'.$file_name.'"');
      $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');

      $objWriter->save('php://output');
    }
  }
  function _parseHtml($html){ 
    $html = preg_replace("/<!DOCTYPE((.|\n)*?)>/ims", "", $html); 
    $html = preg_replace("/<script((.|\n)*?)>((.|\n)*?)<\/script>/ims", "", $html); 
    preg_match("/<head>((.|\n)*?)<\/head>/ims", $html, $matches); 
    $head = !empty($matches[1])?$matches[1]:''; 
    preg_match("/<title>((.|\n)*?)<\/title>/ims", $head, $matches); 
    $this->title = !empty($matches[1])?$matches[1]:''; 
    $html = preg_replace("/<head>((.|\n)*?)<\/head>/ims", "", $html); 
    $head = preg_replace("/<title>((.|\n)*?)<\/title>/ims", "", $head); 
    $head = preg_replace("/<\/?head>/ims", "", $head); 
    $html = preg_replace("/<\/?body((.|\n)*?)>/ims", "", $html); 
    return ['htmlHead' => $head, 'htmlBody' => $html]; 
  } 

  private function get_file_sp($type) {
    
    $type_pkpt = TypePkpt::findOrFail($type);
    $multiple_pkpt = false;
    switch($type_pkpt->code) {
      case 'pkpt_tim':
        $surat_perintah_file = 'surat_perintah_pkpt-form';
        break;
      case 'pkpt_banyak_tim':
        $surat_perintah_file = 'surat_perintah_pkpt_banyak_tim-form';
        $multiple_pkpt = true;
        break;
      case 'pkpt_non_tim':
        $surat_perintah_file = 'surat_perintah_pkpt_non_tim-form';
        break;
      case 'non_pkpt':
        $surat_perintah_file = 'surat_perintah_non_pkpt-form';
        break;
    } 

    return (object) ['surat_perintah_file' => $surat_perintah_file, 'multiple_pkpt' => $multiple_pkpt];
  }
}
