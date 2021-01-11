<?php

namespace App\Http\Controllers\Pemeriksaan;

use App\Http\Controllers\Controller;
use App\Repository\Master\ProgramKerjaAudit;
use App\Repository\SuratPerintah\SuratPerintah;
use App\Service\SuratPerintah\SuratPerintahService;
use App\Service\Pemeriksaan\ProgramKerjaAuditService;
use Datatables;
use Auth;
use Illuminate\Http\Request;

class ProgramKerjaAuditController extends Controller
{
    public function index()
    {
        $id_pegawai = Auth::user()->role->id != 1 ? Auth::user()->user_pegawai->id_pegawai : 0;
        return view('/pemeriksaan/program-kerja-audit/program_kerja_audit-list',[
            'id_pegawai'=> $id_pegawai
        ]);
    }

    public function edit($id)
    {   
        $program_kerja_audit = ProgramKerjaAudit::all();
        $data = SuratPerintah::findOrFail($id);
        return view('/pemeriksaan/program-kerja-audit/program_kerja_audit-form',[
            'data' => $data,
            'program_kerja_audit' => $program_kerja_audit,
        ]);
    }

    public function update($id_sp, Request $request){
        ProgramKerjaAuditService::createOrUpdate($id_sp, $request->input());
        $request->session()->flash('success', "Data berhasil disimpan!");
        return redirect("/pemeriksaan/program-kerja-audit/edit/".$id_sp);
    }

    public function review($id)
    {
        $data = SuratPerintah::findOrFail($id);
        $program_kerja_audit = ProgramKerjaAudit::all();
        return view('/pemeriksaan/program-kerja-audit/program_kerja_audit-review', [
            'data' => $data,
            'program_kerja_audit' => $program_kerja_audit,
        ]);
    }

    public function detail($id)
    {
        $data = SuratPerintah::findOrFail($id);
        $program_kerja_audit = ProgramKerjaAudit::all();
        return view('/pemeriksaan/program-kerja-audit/program_kerja_audit-detail', [
            'data' => $data,
            'program_kerja_audit' => $program_kerja_audit,
        ]);
    }

    public function submit_review($id, Request $request){
        if($request->input('step_approve') == 'review') {
            ProgramKerjaAuditService::review($id, $request->input());
            $request->session()->flash('success', "Data berhasil disimpan!");
            return redirect("/pemeriksaan/program-kerja-audit/review/".$id);
        } else {
            ProgramKerjaAuditService::approve($id);
            $request->session()->flash('success', "Data berhasil disimpan!");
            return redirect("/pemeriksaan/program-kerja-audit");
        }
    }

    public function list_datatables_api()
    {
        $data = SuratPerintahService::get_valid_sp(true)
            ->with((['wilayah', 'kegiatan','program_kerja']));
            
        if(Auth::user()->role->id != 1) {
            $id_pegawai = Auth::user()->user_pegawai->id_pegawai;
                
            $data = $data->whereHas('tim', function($query) use ($id_pegawai) {
                return $query->whereRaw('(id_ketua_tim = '.$id_pegawai. ' OR id_pengendali_teknis = '. $id_pegawai .')');
            });
        }
        
        return Datatables::eloquent($data)->toJson();
    }
}
