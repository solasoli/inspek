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
        $sp = SuratPerintah::findOrFail($id);
        return view('/pemeriksaan/laporan_nhp/laporan_nhp-review', [
            'data' => $sp
        ]);
    }

    public function submit_review($id_sp, Request $request){
        if($request->input('step_approve') == 'review') {
            AuditService::review_by_id_sp($id_sp, $request->input(), 'nhp');
            $request->session()->flash('success', "Data berhasil disimpan!");
            return redirect("/pemeriksaan/laporan_nhp/review/".$id_sp);
        } else {
            AuditService::approve_by_id_sp($id_sp, 'nhp');
            $request->session()->flash('success', "Data berhasil disimpan!");
            return redirect("/pemeriksaan/laporan_nhp");
        }
    }

    public function list_datatables_api($status = 0)
    {
        $data = SuratPerintahService::get_valid_sp(true)
            ->with((['wilayah', 'kegiatan', 'status','program_kerja']));
        if($status == 0) {
            $data = $data->whereIn('id_status_sp', [1,2,3]);
        } else {
            $data = $data->whereIn('id_status_sp', [4,5,6,7]);
        }

        if(Auth::user()->role->id != 1) {
            $id_pegawai = Auth::user()->user_pegawai->id_pegawai;
            $data = $data->whereHas('tim', function($query) use ($id_pegawai) {
                return $query->where('id_pengendali_teknis', $id_pegawai);
            });
        }
        return Datatables::eloquent($data)->toJson();
    }

    
    public function detail($id)
    {
        $sp = SuratPerintah::findOrFail($id);
        return view('/pemeriksaan/laporan_nhp/laporan_nhp-detail', [
            'data' => $sp
        ]);
    }
}
