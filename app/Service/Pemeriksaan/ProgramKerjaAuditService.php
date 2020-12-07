<?php

namespace App\Service\Pemeriksaan;

use DB;
use Auth;
use App\Repository\Master\ProgramKerjaAudit as MstProgramKerjaAudit;
use App\Repository\Pemeriksaan\ProgramKerjaAudit;
use App\Repository\Pemeriksaan\LangkahKerjaPemeriksaan;
use App\Repository\Pemeriksaan\LangkahKerjaPemeriksaanProsedur;
use App\Repository\Pemeriksaan\LangkahKerjaPemeriksaanProsedurDetail;
use App\Repository\Pemeriksaan\LangkahKerjaPemeriksaanProsedurPelaksana;
use App\Repository\Pemeriksaan\LangkahKerjaPemeriksaanReview;
use App\Repository\Pemeriksaan\ProgramKerjaAuditReview;
use App\Repository\SuratPerintah\SuratPerintah;

class ProgramKerjaAuditService
{

  public static function createOrUpdate($id, $data) // $id = id_surat_perintah
  {
    DB::transaction(function () use ($id, $data) {

      $check = SuratPerintah::findOrFail($id);

      if ($check != null) {
        ProgramKerjaAudit::where('id_surat_perintah', $id)
          ->update(['is_deleted' => 1]);
      } else {
        // ...
      }

      self::proccess_data($id, $data);
      DB::commit();
    });
  }

  private static function proccess_data($id_sp, $data)
  {
    DB::transaction(function () use ($id_sp, $data) {

      // find surat perintah
      $surat_perintah = SuratPerintah::findOrFail($id_sp);
      $program_kerja_audit = MstProgramKerjaAudit::all();

      foreach ($program_kerja_audit as $key => $val) {
        $nama_field = str_replace(' ', '_', strtolower(trim($val->nama))) . '_rka';
        $isi = $data[$nama_field];

        $t = ProgramKerjaAudit::firstOrNew([
          'id_surat_perintah' => $id_sp,
          'id_program_kerja_audit' => $val->id,
        ]);
        $t->isi = !is_null($isi) ? $isi : '';
        $t->created_at = date('Y-m-d H:i:s');
        $t->created_by = Auth::id();
        $t->save();
      }

      // detaching LKP
      $id_lkp = [];

      // inserting Langkah Kerja Pemeriksaan Rinci
      $mapping_lkp = json_decode($data['mapping_lkp']);
      $delete_data = [
        'is_deleted' => 1,
        'deleted_by' => Auth::user()->id,
        'deleted_at' => date("Y-m-d H:i:s"),
      ];

      foreach ($mapping_lkp as $iLkp => $rLkp) {
        
        $data_ins_lkp = [
          'judul_tugas' => $rLkp->judulTugas,
          'sub_judul_tugas' => $rLkp->subJudulTugas[0],
          'tujuan_pemeriksaan' => $rLkp->tujuanPemeriksaan,
        ];

        if(!self::checkValidateLkp($data_ins_lkp))
          continue;

        if ($rLkp->idLkp == 0) {
          $lkp = $surat_perintah->langkah_kerja_pemeriksaan()->create($data_ins_lkp);
        } else {
          $lkp = LangkahKerjaPemeriksaan::findOrNew($rLkp->idLkp);
          $lkp->update($data_ins_lkp);
        }

        $id_lkp[] = $lkp->id;

        $lkp->sub_judul()->update($delete_data);
        // saving sub_judul_tugas
        if (count($rLkp->subJudulTugas) > 1) {
          $list_sub_judul_tugas = [];
          for ($iSjt = 1; $iSjt < count($rLkp->subJudulTugas); $iSjt++) {
            $data_sub_judul_tugas = [
              'sub_judul' => $rLkp->subJudulTugas[$iSjt]
            ];

            $list_sub_judul_tugas[] = $data_sub_judul_tugas;
          }
          $lkp->sub_judul()->createMany($list_sub_judul_tugas);
        }

        $id_available_prosedur = [];
        // saving prosedur
        foreach ($rLkp->prosedur as $iUr => $rUr) {
          $data_prosedur = [
            'prosedur' => $rUr->prosedur
          ];

          if($rUr->idProsedur == 0) {
            $prosedur = $lkp->prosedur()->create($data_prosedur);
          } else {
            $prosedur = LangkahKerjaPemeriksaanProsedur::findOrFail($rUr->idProsedur);
            $prosedur->update($data_prosedur);
          }

          $id_available_prosedur[] = $prosedur->id;

          $id_available_prosedur_detail = [];
          // saving prosedur detail
          foreach ($rUr->prosedurDetail as $iUrD => $rUrD) {
            $data_prosedur_detail = [
              'prosedur_detail' => $rUrD->prosedurDetail
            ];
            if($rUrD->idProsedurDetail == 0) {
              $prosedur_detail = $prosedur->prosedur_detail()->create($data_prosedur_detail);
            } else {
              $prosedur_detail = LangkahKerjaPemeriksaanProsedurDetail::findOrFail($rUrD->idProsedurDetail);
              $prosedur_detail->update($data_prosedur_detail);
            }

            $id_available_prosedur_detail[] = $prosedur_detail->id;
          }
          // delete the other prosedur detail
          LangkahKerjaPemeriksaanProsedurDetail::where('id_prosedur', $prosedur->id)->whereNotIn('id', $id_available_prosedur_detail)->update($delete_data);

          // saving pelaksana
          $pelaksana = $rUr->pelaksana;
          $data_prosedur_pelaksana = [
            'id_prosedur' => $prosedur->id,
            'id_pelaksana_rencana' => $pelaksana->rencana->pelaksana,
            'durasi_rencana' => $pelaksana->rencana->durasi > 0 ? $pelaksana->rencana->durasi : 0,
            'id_pelaksana_realisasi' => $pelaksana->realisasi->pelaksana,
            'durasi_realisasi' => $pelaksana->realisasi->durasi > 0 ? $pelaksana->realisasi->durasi : 0,
          ];

          $findPelaksana = $prosedur->prosedur_pelaksana;
          if(is_null($findPelaksana)) {
            $pelaksana = LangkahKerjaPemeriksaanProsedurPelaksana::create($data_prosedur_pelaksana);
          } else {
            $pelaksana = $findPelaksana->update($data_prosedur_pelaksana);
          }
        }
        
        // delete the other prosedur
        LangkahKerjaPemeriksaanProsedur::where('id_lkp', $rLkp->idLkp)->whereNotIn('id', $id_available_prosedur)->update($delete_data);
      }

      LangkahKerjaPemeriksaan::where('id_surat_perintah', $id_sp)->whereNotIn('id', $id_lkp)->update($delete_data);

      DB::commit();
    });
  }

  public static function review($id_sp, $data)
  {
    DB::transaction(function () use ($id_sp, $data) {

      // find surat perintah
      $surat_perintah = SuratPerintah::findOrFail($id_sp);
      $program_kerja_audit = MstProgramKerjaAudit::all();

      foreach ($program_kerja_audit as $key => $val) {
        $nama_field = str_replace(' ', '_', strtolower(trim($val->nama))) . '_rka';
        $isi = !is_null($data[$nama_field]) ? $data[$nama_field] : '';

        $t = ProgramKerjaAuditReview::firstOrNew([
          'id_surat_perintah' => $id_sp,
          'id_program_kerja_audit' => $val->id,
        ]);
        $t->isi = $isi;
        $t->created_at = date('Y-m-d H:i:s');
        $t->created_by = Auth::id();
        $t->save();
      }

      foreach($surat_perintah->langkah_kerja_pemeriksaan as $row) {
        $t = LangkahKerjaPemeriksaanReview::where('id_langkah_kerja_pemeriksaan', $row->id)
        ->where('is_deleted', 0)->first();
        if(!is_null($t)) {
          $t->isi = !is_null($data['lkp_review_'.$row->id]) ? $data['lkp_review_'.$row->id] : '';
          $t->save();
        } else {
          $t = new LangkahKerjaPemeriksaanReview;
          $t->isi = !is_null($data['lkp_review_'.$row->id]) ? $data['lkp_review_'.$row->id] : '';
          $t->id_langkah_kerja_pemeriksaan = $row->id;
          $t->save();
        }
      }
      DB::commit();
    });
  }

  public static function approve($id_sp)
  {
    DB::transaction(function () use ($id_sp) {

      // find surat perintah
      $surat_perintah = SuratPerintah::findOrFail($id_sp);
      $surat_perintah->is_approved_pka = 1;
      $surat_perintah->save();

      foreach($surat_perintah->langkah_kerja_pemeriksaan as $row) {
        
        $t = LangkahKerjaPemeriksaanReview::where('id_langkah_kerja_pemeriksaan', $row->id)
        ->update(['is_deleted' => 1]);
      }
      DB::commit();
    });
  }

  private static function checkValidateLkp($data = []) {
    $let_all_filled = true;
    foreach($data as $idx => $row) {
      if(trim($row) == '') {
        $let_all_filled = false;
      }
    }

    return $let_all_filled;
  }
}
