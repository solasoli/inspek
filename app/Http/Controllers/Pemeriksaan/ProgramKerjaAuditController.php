<?php

namespace App\Http\Controllers\Pemeriksaan;

use App\Http\Controllers\Controller;
use App\Service\SuratPerintah\SuratPerintahService;
use Datatables;

class ProgramKerjaAuditController extends Controller
{
    public function index()
    {
        return view('/pemeriksaan/program-kerja-audit/program_kerja_audit-list');
    }

    public function edit($id)
    {
        return view('/pemeriksaan/program-kerja-audit/program_kerja_audit-form');
    }

    public function list_datatables_api()
    {
        $data = SuratPerintahService::get_valid_sp(true)
            ->with((['wilayah', 'kegiatan']));
        return Datatables::eloquent($data)->toJson();
    }
}
