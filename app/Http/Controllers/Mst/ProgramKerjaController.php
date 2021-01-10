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
use Maatwebsite\Excel\Facades\Excel;
use App\Export\ProgramKerjaExport;
use App\Repository\Master\JenisPengawasan;
use View;

date_default_timezone_set('Asia/Jakarta');

class ProgramKerjaController extends Controller
{
    public function index()
    {
      $opd = Skpd::where("is_deleted", 0)->get();
      $wilayah = Wilayah::where("is_deleted", 0)->get();
      $program_kerja = ProgramKerja::where("is_deleted", 0)->get();
      $tahun_awal_program_kerja = ProgramKerja::where('is_deleted', 0)
      ->limit(1)
      ->orderBy('dari', 'ASC')
      ->select(DB::raw("YEAR(dari) AS tahun"))
      ->first();

      $jenis_kegiatan = Kegiatan::where('is_deleted', 0)->get();
      $jenis_pengawasan = JenisPengawasan::where('is_deleted', 0)->get();
      return view('Mst.program_kerja-list', [
        'opd' => $opd,
        'program_kerja' => $program_kerja,
        'wilayah' => $wilayah,
        'tahun_awal_program_kerja' => !is_null($tahun_awal_program_kerja) ? $tahun_awal_program_kerja->tahun : date("Y"),
        'jenis_pengawasan' => $jenis_pengawasan,
        'jenis_kegiatan' => $jenis_kegiatan
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
      $data = ProgramKerja::with(['skpd', 'kegiatan', 'wilayah','jenis_pengawasan'])->where('is_deleted', 0);
      return Datatables::eloquent($data)->toJson();
    }

    public function get_program_kerja_by_id(Request $request)
    {
      $data = ProgramKerja::with(['skpd','wilayah','jenis_pengawasan'])->find($request->input('id'));

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

    public function print($method = 'html', $tahun = null)
    {
      $tahun = is_null($tahun) ? date("Y") : $tahun;
      if($method == 'html') {
        $data = ProgramKerja::where('is_deleted', 0)->orderBy('dari')
        ->whereRaw("YEAR(dari) = {$tahun}")
        ->get();
        return view('Mst.program_kerja-print', [
          'data' => $data
        ]);
      } else if($method == 'excel') {
        return Excel::download(new ProgramKerjaExport($tahun), "Program Kerja - {$tahun}.xlsx");
      } else if($method == 'pdf') {
        return Excel::download(new ProgramKerjaExport($tahun), "Program Kerja - {$tahun}.pdf");
      } else if($method == 'word') {
        $data = ProgramKerja::where('is_deleted', 0)->orderBy('dari')
        ->whereRaw("YEAR(dari) = {$tahun}")
        ->get();
        // Creating the new document...
        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        /* Note: any element you append to a document must reside inside of a Section. */

        // Adding an empty Section to the document...
        $section = $phpWord->addSection();

        // Adding Text element to the Section having font styled by default...
        $view_content = View::make('Mst.program_kerja-print', ['data' => $data])->render();
        $view_content = $this->_parseHtml($view_content);

        
        $html = '<table><tr><td>test</td></tr></table>';

        \PhpOffice\PhpWord\Shared\Html::addHtml($section, $view_content['htmlBody']);
        // $section->addHtml($section, $view_content['htmlBody']);
        // $section->addText('naha ai sia goblog');

        // Saving the document as HTML file...
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $file_name = "Program Kerja - {$tahun}.docx";

        $objWriter->save(public_path('upload_file/'. $file_name));
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
}
