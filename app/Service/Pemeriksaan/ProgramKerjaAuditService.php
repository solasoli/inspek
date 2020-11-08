<?php

namespace App\Service\Pemeriksaan;

use DB;
use Auth;
use App\Repository\Master\ProgramKerjaAudit as MstProgramKerjaAudit;
use App\Repository\Pemeriksaan\ProgramKerjaAudit;
use App\Repository\Pemeriksaan\LangkahKerjaPemeriksaan;
use App\Repository\SuratPerintah\SuratPerintah;

class ProgramKerjaAuditService
{

  public static function createOrUpdate($id, $data) // $id = id_surat_perintah
  {
    DB::transaction(function() use ($id, $data) {
      
      $check = SuratPerintah::findOrFail($id);

      if ($check != null) {
        ProgramKerjaAudit::where('id_surat_perintah', $id)
        ->update(['is_deleted' => 1]);
      }
      else {
        // ...
      }

      self::proccess_data($id, $data);
      DB::commit();

    });
  }

  private static function proccess_data($id_sp, $data)
  {
    DB::transaction(function() use ($id_sp, $data) {
      
      // find surat perintah
      $surat_perintah = SuratPerintah::findOrFail($id_sp);
      $program_kerja_audit = MstProgramKerjaAudit::all();

      foreach ($program_kerja_audit as $key => $val) {
        $nama_field = str_replace(' ','_', strtolower(trim($val->nama))).'_rka';
        $isi = $data[$nama_field];

        $t = ProgramKerjaAudit::firstOrNew([
          'id_surat_perintah' => $id_sp,
          'id_program_kerja_audit' => $val->id
        ]);
        $t->isi = $isi;
        $t->created_at = date('Y-m-d H:i:s');
        $t->created_by = Auth::id();
        $t->save();
      }

      // detaching LKP
      $surat_perintah->langkah_kerja_pemeriksaan()->delete();
      
      // inserting Langkah Kerja Pemeriksaan Rinci
      $mapping_lkp = json_decode($data['mapping_lkp']);
      foreach ($mapping_lkp as $iLkp => $rLkp) {
        $data_ins_lkp = [
          'judul_tugas' => $rLkp->judulTugas,
          'sub_judul_tugas' => $rLkp->subJudulTugas[0],
          'prosedur_pemeriksaan' => $rLkp->prosedurPemeriksaan,
          'tujuan_pemeriksaan' => $rLkp->tujuanPemeriksaan,
          'id_pelaksana_rencana' => $rLkp->rencana->pelaksana,
          'durasi_rencana' => $rLkp->rencana->durasi,
          'id_pelaksana_realisasi' => $rLkp->realisasi->pelaksana,
          'durasi_realisasi' => $rLkp->realisasi->durasi
        ];
        $new_lkp = $surat_perintah->langkah_kerja_pemeriksaan()->create($data_ins_lkp);

        // saving sub_judul_tugas
        if (count($rLkp->subJudulTugas) > 1) {
          $list_sub_judul_tugas = [];
          for ($iSjt = 1; $iSjt < count($rLkp->subJudulTugas); $iSjt++) {
            $data_sub_judul_tugas = [
              'sub_judul' => $rLkp->subJudulTugas[$iSjt]
            ];

            $list_sub_judul_tugas[] = $data_sub_judul_tugas; 
          }
          $new_lkp->sub_judul()->createMany($list_sub_judul_tugas);
        }

        // saving uraian
        foreach ($rLkp->uraian as $iUr => $rUr) {
          $data_uraian = [
            'uraian' => $rUr->uraian
          ];

          $new_uraian = $new_lkp->uraian()->create($data_uraian);

          // saving uraian detail
          $list_uraian_detail = [];
          foreach ($rUr->uraianDetail as $iUrD => $rUrD) {
            $data_uraian_detail = [
              'uraian_detail' => $rUrD
            ];
            $list_uraian_detail[] = $data_uraian_detail;
          }
          $new_uraian->uraian_detail()->createMany($list_uraian_detail);
        }
      }
      DB::commit();
    });
  }

}
