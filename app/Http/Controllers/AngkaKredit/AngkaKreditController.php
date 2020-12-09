<?php

namespace App\Http\Controllers\AngkaKredit;

use App\Http\Controllers\Controller;
use App\Repository\AngkaKredit\SubUnsur;
use App\Repository\AngkaKredit\Unsur;
use App\Repository\Pegawai\Pegawai;
use App\Repository\Pemeriksaan\AuditBerkas;
use App\Repository\Pemeriksaan\KertasKerja;
use App\Repository\SuratPerintah\SuratPerintah;
use App\Service\SuratPerintah\SuratPerintahService;
use App\Service\Pemeriksaan\AuditService;
use Datatables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Auth;

class AngkaKreditController extends Controller
{
    public function index()
    {
        $id_pegawai = Auth::user()->role->id != 1 ? Auth::user()->user_pegawai->id_pegawai : 0;
        $unsur = Unsur::where('is_deleted', 0)->get();
        return view('/angka_kredit/angka_kredit/angka_kredit-list',[
            'id_pegawai' => $id_pegawai,
            'unsur' => $unsur
        ]);
    }

    public function create($unsur_code)
    {
        $pegawai = null;
        if(Auth::user()->role->id == 1) {
            $pegawai = Pegawai::where('is_deleted', 0)->get();
        }
        
        $unsur = Unsur::where('is_deleted', 0)->where('code', $unsur_code)->first();

        if($unsur_code == 'pendidikan') {
            return view('/angka_kredit/angka_kredit/pendidikan/angka_kredit_pendidikan-form',[
                'unsur' => $unsur,
                'pegawai' => $pegawai
            ]);
        }
    }

    public function store(Request $request, $id_sp){
        dd($request->input());
    }

    public function get_sub_unsur($unsur_code = '', $id_pegawai = 0) {
        $pegawai = Pegawai::findOrFail($id_pegawai);
        $tipe_auditor = $pegawai->jabatan->tipe_auditor_jabatan->tipe_auditor;
        $unsur = Unsur::where('is_deleted', 0)->where('code', $unsur_code)->first();
        $sub_unsur = SubUnsur::where('is_deleted', 0)
        ->where('id_unsur', $unsur->id)
        ->where('id_tipe_auditor', $tipe_auditor->id)
        ->get();

        return response()->json(['data' => $sub_unsur]);
    }
    
    public function get_butir_kegiatan($id_sub_unsur = 0, $id_pegawai = 0) {
        $pegawai = Pegawai::findOrFail($id_pegawai);
        $tipe_auditor = $pegawai->jabatan->tipe_auditor_jabatan->tipe_auditor;
        $sub_unsur = SubUnsur::findOrFail($id_sub_unsur);

        return response()->json(['data' => $sub_unsur->butir_kegiatan()->with('satuan')->get()]);
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
        if(Auth::user()->role->id != 1) {
            $kk = KertasKerja::where('created_by', Auth::user()->id)->first();
            
            if($kk != null) {
                return redirect("/pemeriksaan/audit/edit/".$kk->id);
            } else {
                return redirect("/pemeriksaan/audit/add/". $id);
            }
        }

        $id_pegawai = Auth::user()->role->id != 1 ? Auth::user()->user_pegawai->id_pegawai : 0;
        $sp = SuratPerintah::findOrFail($id);
        return view('/pemeriksaan/audit/audit-review-list', [
            'data' => $sp,
            'id_pegawai' => $id_pegawai
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
