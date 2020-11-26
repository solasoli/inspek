<?php

namespace App\Http\Controllers\Pemeriksaan;

use App\Http\Controllers\Controller;
use App\Repository\SuratPerintah\SuratPerintah;
use App\Service\SuratPerintah\SuratPerintahService;
use App\Service\Pemeriksaan\AuditService;
use Datatables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Auth;

class AuditController extends Controller
{
    public function index()
    {
        return view('/pemeriksaan/audit/audit-list');
    }

    public function edit($id)
    {
        $sp = SuratPerintah::findOrFail($id);
        return view('/pemeriksaan/audit/audit-form', [
            'data' => $sp
        ]);
    }

    public function update($id_sp, Request $request){
        AuditService::createOrUpdate($id_sp, $request->input());
        $request->session()->flash('success', "Data berhasil disimpan!");
        return redirect("/pemeriksaan/audit/edit/".$id_sp);
    }

    public function list_datatables_api()
    {
        $data = SuratPerintahService::get_valid_sp(true)
            ->with((['wilayah', 'kegiatan']));
        return Datatables::eloquent($data)->toJson();
    }

    public function upload_bukti_kertas_kerja(Request $request, $id_sp)
    {
        $this->validate($request, [
            'file' => 'required',
        ]);

        // menyimpan data file yang diupload ke variabel $file
        $file = $request->file('file');
        $nama_file = str_replace('.' . $file->getClientOriginalExtension(), '', $file->getClientOriginalName());
        $nama_file .= '_' . time() . '.' . $file->getClientOriginalExtension();

        // isi dengan nama folder tempat kemana file diupload
        $tujuan_upload = 'upload_file';
        $file->move($tujuan_upload, $nama_file);

        // insert into audit berkas
        AuditService::insert_berkas($id_sp, $nama_file);

        return ['file_url' => URL::to('upload_file/'.$nama_file), 'file_name' => $nama_file];
    }
}
