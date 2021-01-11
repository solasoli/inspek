<?php

namespace App\Http\Controllers\TindakLanjut;

use App\Http\Controllers\Controller;
use App\Repository\Pemeriksaan\KertasKerja;
use App\Repository\SuratPerintah\SuratPerintah;
use App\Service\Pemeriksaan\AuditService;
use App\Service\SuratPerintah\SuratPerintahService;
use App\Service\Pemeriksaan\LaporanNhpService;
use App\Service\TindakLanjut\TindakLanjutService;
use Datatables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Auth;

class MatrikController extends Controller
{
    public function index()
    {
        return view('/tindak_lanjut/matrik/matrik-list');
    }

    public function edit($id)
    {
        $sp = SuratPerintah::findOrFail($id);
        return view('/tindak_lanjut/matrik/tindak_lanjut-form', [
            'data' => $sp
        ]);
    }
    
    public function update($id_sp, Request $request){
        TindakLanjutService::createOrUpdate($id_sp, $request->input(), 'lhp');
        $request->session()->flash('success', "Data berhasil disimpan!");
        return redirect("/tindak_lanjut/matrik/edit/".$id_sp);
    }

    public function review_list($id)
    {
        $sp = SuratPerintah::findOrFail($id);
        return view('/tindak_lanjut/matrik/matrik-review-list', [
            'data' => $sp
        ]);
    }

    public function review($id)
    {
        $sp = SuratPerintah::findOrFail($id);
        return view('/tindak_lanjut/matrik/matrik-review', [
            'data' => $sp
        ]);
    }

    public function submit_review($id_sp, Request $request){
        if($request->input('step_approve') == 'review') {
            TindakLanjutService::review($id_sp, $request->input());
            $request->session()->flash('success', "Data berhasil disimpan!");
            return redirect("/tindak_lanjut/matrik/review/".$id_sp);
        } else {
            
            TindakLanjutService::approve($id_sp);
            $request->session()->flash('success', "Data berhasil disimpan!");
            return redirect("/tindak_lanjut/matrik");
        }
    }

    public function list_datatables_api($status = 0)
    {
        $data = SuratPerintahService::get_valid_sp(true)
            ->with((['wilayah', 'kegiatan', 'status','program_kerja']))
            ->where('id_status_sp', 7)
            ->whereRaw("(no_lhp IS NOT NULL AND no_lhp != '')")
            ->where('is_approved_tindak_lanjut', $status);
            
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
        return view('/tindak_lanjut/matrik/matrik-detail', [
            'data' => $sp
        ]);
    }
}
