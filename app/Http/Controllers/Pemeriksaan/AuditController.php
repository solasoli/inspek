<?php

namespace App\Http\Controllers\Pemeriksaan;

use App\Http\Controllers\Controller;
use App\Repository\Pemeriksaan\AuditBerkas;
use App\Repository\Pemeriksaan\KertasKerja;
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

    public function add($id)
    {
        $new_kertas_kerja = KertasKerja::create(['id_surat_perintah' => $id]);
        return redirect("/pemeriksaan/audit/edit/".$new_kertas_kerja->id);

    }
    
    public function store($id_sp, Request $request){
        AuditService::create($id_sp, $request->input());
        $request->session()->flash('success', "Data berhasil disimpan!");
        return redirect("/pemeriksaan/audit/edit/".$id_sp);
    }

    public function edit($id)
    {
        $sp = KertasKerja::findOrFail($id);
        return view('/pemeriksaan/audit/audit-form', [
            'data' => $sp
        ]);
    }

    public function update($id, Request $request){
        AuditService::createOrUpdate($id, $request->input());
        $request->session()->flash('success', "Data berhasil disimpan!");
        return redirect("/pemeriksaan/audit/edit/".$id);
    }
    
    public function review_list($id)
    {
        $sp = SuratPerintah::findOrFail($id);
        return view('/pemeriksaan/audit/audit-review-list', [
            'data' => $sp
        ]);
    }


    public function detail($id)
    {
        $data = KertasKerja::findOrFail($id);
        $sp = SuratPerintah::findOrFail($data->surat_perintah->id);
        return view('/pemeriksaan/audit/audit-detail', [
            'data' => $data,
            'sp' => $sp
        ]);
    }

    public function remove_audit_berkas($id) {
        $audit = AuditBerkas::find($id);
        $audit->is_deleted = 1;
        $audit->save();

    }

    public function review($id)
    {
        $data = KertasKerja::findOrFail($id);
        $sp = SuratPerintah::findOrFail($data->surat_perintah->id);
        return view('/pemeriksaan/audit/audit-review', [
            'data' => $data,
            'sp' => $sp
        ]);
    }

    public function submit_review($id_kertas_kerja, Request $request){
        if($request->input('step_approve') == 'review') {
            AuditService::review($id_kertas_kerja, $request->input());
            $request->session()->flash('success', "Data berhasil disimpan!");
            return redirect("/pemeriksaan/audit/review/".$id_kertas_kerja);
        } else {
            
            $data = KertasKerja::findOrFail($id_kertas_kerja);
            AuditService::approve($id_kertas_kerja);
            $request->session()->flash('success', "Data berhasil disimpan!");
            return redirect("/pemeriksaan/audit/review_list/".$data->surat_perintah->id);
        }
    }

    
    public function submit_kompilasi($id_sp, Request $request){
        AuditService::submit_kompilasi($id_sp, $request->input());
        $request->session()->flash('success', "Data berhasil disimpan!");
        return redirect("/pemeriksaan/audit/review_list/".$id_sp);
    }

    public function list_datatables_api()
    {
        $data = SuratPerintahService::get_valid_sp(true)
            ->with((['wilayah', 'kegiatan','status']));
    
        if(Auth::user()->role->id != 1) {
            $id_pegawai = Auth::user()->user_pegawai->id_pegawai;
            $data = $data->whereRaw('(id_ketua_tim = '.$id_pegawai. ' OR (select count(id) FROM pkpt_surat_perintah_anggota WHERE id_anggota = '. $id_pegawai .') > 0)');
        }
        
        return Datatables::eloquent($data)->toJson();
    }

    public function upload_bukti_kertas_kerja(Request $request, $id)
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
        $insert_berkas = AuditService::insert_berkas($id, $nama_file);

        return ['file_url' => URL::to('upload_file/'.$nama_file), 'file_name' => $nama_file, 'id' => $insert_berkas->id];
    }
}
