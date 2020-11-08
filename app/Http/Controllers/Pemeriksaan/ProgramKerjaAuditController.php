<?php

namespace App\Http\Controllers\Pemeriksaan;

use App\Http\Controllers\Controller;
use App\Repository\Master\ProgramKerjaAudit;
use App\Repository\SuratPerintah\SuratPerintah;
use App\Service\SuratPerintah\SuratPerintahService;
use App\Service\Pemeriksaan\ProgramKerjaAuditService;
use Datatables;
use Illuminate\Http\Request;

class ProgramKerjaAuditController extends Controller
{
    public function index()
    {
        return view('/pemeriksaan/program-kerja-audit/program_kerja_audit-list');
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

    public function list_datatables_api()
    {
        $data = SuratPerintahService::get_valid_sp(true)
            ->with((['wilayah', 'kegiatan']));
        return Datatables::eloquent($data)->toJson();
    }
}
