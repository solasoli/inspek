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

class LaporanLhpController extends Controller
{
    public function index()
    {
        return view('/pemeriksaan/laporan_lhp/laporan_lhp-list');
    }

    public function review_list($id)
    {
        $sp = SuratPerintah::findOrFail($id);
        return view('/pemeriksaan/laporan_lhp/laporan_lhp-review-list', [
            'data' => $sp
        ]);
    }

    public function review($id)
    {
        $sp = SuratPerintah::findOrFail($id);
        return view('/pemeriksaan/laporan_lhp/laporan_lhp-review', [
            'data' => $sp
        ]);
    }

    public function submit_review($id_sp, Request $request){
        if($request->input('step_approve') == 'review') {
            AuditService::review_by_id_sp($id_sp, $request->input(), 'lhp');
            $request->session()->flash('success', "Data berhasil disimpan!");
            return redirect("/pemeriksaan/laporan_lhp/review/".$id_sp);
        } else {
            
            AuditService::approve_by_id_sp($id_sp, 'lhp');
            $request->session()->flash('success', "Data berhasil disimpan!");
            return redirect("/pemeriksaan/laporan_lhp");
        }
    }

    public function list_datatables_api($status = 0)
    {
        $data = SuratPerintahService::get_valid_sp(true)
            ->with((['wilayah', 'kegiatan', 'status','program_kerja']));
            
        if($status == 0) {
            $data = $data->whereIn('id_status_sp', [1,2,3,4,5]);
        } else {
            $data = $data->whereIn('id_status_sp', [6,7]);
        }
        
        if(Auth::user()->role->id != 1) {
            $id_pegawai = Auth::user()->user_pegawai->id_pegawai;
            $data = $data->whereHas('tim', function($query) use ($id_pegawai) {
                return $query->whereRaw('(id_inspektur = '. $id_pegawai . ' OR id_inspektur_pembantu = '. $id_pegawai.')');
            });
        }
        return Datatables::eloquent($data)->toJson();
    }

    public function detail($id)
    {
        $sp = SuratPerintah::findOrFail($id);
        return view('/pemeriksaan/laporan_lhp/laporan_lhp-detail', [
            'data' => $sp
        ]);
    }
}
