<?php

namespace App\Http\Controllers\Pemeriksaan;

use App\Http\Controllers\Controller;
use App\Repository\Pemeriksaan\KertasKerja;
use App\Repository\SuratPerintah\SuratPerintah;
use App\Service\Pemeriksaan\AuditService;
use App\Service\SuratPerintah\SuratPerintahService;
use App\Service\Pemeriksaan\LaporanNhpService;
use Datatables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Auth;

class LaporanNhpController extends Controller
{
    public function index()
    {
        return view('/pemeriksaan/laporan_nhp/laporan_nhp-list');
    }

    public function review_list($id)
    {
        $sp = SuratPerintah::findOrFail($id);
        return view('/pemeriksaan/laporan_nhp/laporan_nhp-review-list', [
            'data' => $sp
        ]);
    }

    public function review($id)
    {
        $data = KertasKerja::findOrFail($id);
        $sp = SuratPerintah::findOrFail($data->surat_perintah->id);
        return view('/pemeriksaan/laporan_nhp/laporan_nhp-review', [
            'data' => $data,
            'sp' => $sp
        ]);
    }

    public function submit_review($id_kertas_kerja, Request $request){
        if($request->input('step_approve') == 'review') {
            AuditService::review($id_kertas_kerja, $request->input(), 'nhp');
            $request->session()->flash('success', "Data berhasil disimpan!");
            return redirect("/pemeriksaan/laporan_nhp/review/".$id_kertas_kerja);
        } else {
            
            $data = KertasKerja::findOrFail($id_kertas_kerja);
            AuditService::approve($id_kertas_kerja, 'nhp');
            $request->session()->flash('success', "Data berhasil disimpan!");
            return redirect("/pemeriksaan/laporan_nhp/review_list/".$data->surat_perintah->id);
        }
    }

    public function list_datatables_api()
    {
        $data = SuratPerintahService::get_valid_sp(true)
            ->with((['wilayah', 'kegiatan']));
        return Datatables::eloquent($data)->toJson();
    }

}
