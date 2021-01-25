<?php

namespace App\Service\SuratPerintah;

use App\Repository\AngkaKredit\Unsur;
use DB;
use Auth;
use App\Repository\Master\Kegiatan;
use App\Repository\SuratPerintah\SuratPerintah;
use App\Repository\SuratPerintah\SuratPerintahAnggota;
use App\Repository\SuratPerintah\SuratPerintahSasaran;
use App\Repository\Master\ProgramKerja;
use App\Service\Master\KegiatanService;
use App\Service\Master\ProgramKerjaService;
use App\Service\Master\PeriodeService;
use App\Service\Master\WilayahService;
use App\Service\Pegawai\PegawaiService;
use App\Service\Master\SasaranService;

use App\Repository\Master\DasarSurat;
use App\Repository\SuratPerintah\SuratPerintahSkpd;
use App\Repository\SuratPerintah\SuratPerintahTim;
use App\Repository\SuratPerintah\SuratPerintahWilayah;
use App\Repository\SuratPerintah\TypePkpt;

class SuratPerintahService
{

  public static function create($data, $type_pkpt = 1)
  {
    $t = new SuratPerintah;
    $data['type'] = $type_pkpt;
    return self::proccess_data($t, $data);
  }

  public static function update($id_sp, $data)
  {
    $t = SuratPerintah::findOrFail($id_sp);
    $data['type'] = $t->is_pkpt;
    return self::proccess_data($t, $data);
  }

  private static function proccess_data(SuratPerintah $sp, $data)
  {

    DB::transaction(function () use ($sp, $data) {

      $type = $data['type'];
      $input = $data;
      $new_sasaran = [];

      $type_pkpt = TypePkpt::findOrFail($type);
      if ($type_pkpt->code == 'non_pkpt')  { // Surat Perintah Non PKPT

        // prepare data kegiatan
        $data_kegiatan = [
          'kegiatan' => $input['kegiatan'],
          'wilayah' => $input['wilayah'],
          'opd' => $input['opd'],
          'dari' => $input['dari'],
          'sampai' => $input['sampai'],
          'sasaran' => $input['sasaran_kegiatan'],
          'sub_kegiatan' => $input['sub_kegiatan'],
          'anggaran' => $input['anggaran'],
          'jml_wakil_penanggung_jawab' => 1,
          'jml_pengendali_teknis' => 1,
          'jml_ketua_tim' => 1,
          'jml_anggota' => count($input['anggota']),
        ];

        $kegiatan = null;

        if (isset($sp->id_program_kerja)) {

          $program_kerja = ProgramKerjaService::update($sp->id_program_kerja, $data_kegiatan);
        } else {
          // buat Program Kerja
          $program_kerja = ProgramKerjaService::create($data_kegiatan, $type);
        }
        
        // set new sasaran to mst_sasaran
        $get_created_sasaran =  SasaranService::get_sasaran_by_id_program_kerja($program_kerja->id);
        foreach($get_created_sasaran as $csi => $rcs) { 
          $new_sasaran[] = $rcs->id;
        }
      } else { // Surat Perintah PKPT
        $program_kerja = ProgramKerja::findOrFail($input['program_kerja']);
        $kegiatan = Kegiatan::findOrFail($program_kerja->id_kegiatan);
      } 

      $dari = explode('-', $input['dari']);
      $dari = $dari[2] . '-' . $dari[1] . '-' . $dari[0];
      $sampai = explode('-', $input['sampai']);
      $sampai = $sampai[2] . '-' . $sampai[1] . '-' . $sampai[0];

      $data = [
        'dari' => $dari,
        'sampai' => $sampai
      ];

      
      $t = $sp;
      // $t->id_wilayah = $input['wilayah'];
      $t->id_inspektur = $input['inspektur'];
      // $t->id_inspektur_pembantu = $input['inspektur_pembantu'];
      // $t->id_pengendali_teknis = $input['pengendali_teknis'];
      // $t->id_ketua_tim = $input['ketua_tim'];
      $t->id_kegiatan = $program_kerja->id_kegiatan;
      $t->id_program_kerja = $program_kerja->id;
      $t->no_surat = '';
      $t->dasar_surat = $input['dasar_surat'];
      $t->tembusan = $input['tembusan'];
      $t->untuk = '';
      $t->dari = $data['dari'];
      $t->sampai = $data['sampai'];
      $t->created_at = date('Y-m-d H:i:s');
      $t->created_by = Auth::id();
      $t->updated_at = NULL;
      $t->updated_by = 0;
      $t->deleted_at = NULL;
      $t->deleted_by = 0;
      $t->is_deleted = 0;
      $t->is_pkpt = $type;
      $t->is_lampiran = $type;
      $t->save();

      DB::table('pkpt_surat_perintah_anggota')
        ->where('id_surat_perintah', $t->id)
        ->update(['is_deleted' => 1]);

      /*
      // insert anggota
      foreach ($input['anggota'] as $idx => $row) {
        $na = new SuratPerintahAnggota;
        $na->id_surat_perintah = $t->id;
        $na->id_anggota = $row;
        $na->save();
      }
      */

      DB::table('pkpt_surat_perintah_tim')
        ->where('id_surat_perintah', $t->id)
        ->update(['is_deleted' => 1]);
      // surat perintah SKPD
      DB::table('pkpt_surat_perintah_skpd')
        ->where('id_surat_perintah', $t->id)
        ->update(['is_deleted' => 1]);
      $mapping_tim = json_decode($input['mapping_tim']);
      foreach($mapping_tim as $mt) {
        // insert tim
        $new_tim = new SuratPerintahTim;
        $new_tim->id_surat_perintah = $t->id;
        $new_tim->no_tim = $mt->no_tim > 0 ? $mt->no_tim : 1;
        $new_tim->id_inspektur = $mt->inspektur;
        $new_tim->id_inspektur_pembantu = isset($mt->inspektur_pembantu) && $mt->inspektur_pembantu > 0 ? $mt->inspektur_pembantu : 0;
        $new_tim->id_pengendali_teknis = isset($mt->pengendali_teknis) && $mt->pengendali_teknis > 0 ? $mt->pengendali_teknis : 0;
        $new_tim->id_ketua_tim = isset($mt->ketua_tim) && $mt->ketua_tim > 0 ? $mt->ketua_tim : 0;
        $new_tim->save();

        // insert anggota
        foreach ($mt->anggota as $idx => $row) {
          $na = new SuratPerintahAnggota;
          $na->id_surat_perintah = $t->id;
          $na->id_anggota = $row;
          $na->id_surat_perintah_tim = $new_tim->id;
          $na->save();
        }

        // insert skpd        
        foreach ($mt->opd as $idx => $row) {
          $na = new SuratPerintahSkpd;
          $na->id_surat_perintah = $t->id;
          $na->id_skpd = $row;
          $na->id_surat_perintah_tim = $new_tim->id;
          $na->save();
        }
      }

      $wilayah = json_decode($input['wilayah']);

      DB::table('pkpt_surat_perintah_wilayah')
        ->where('id_surat_perintah', $t->id)
        ->update(['is_deleted' => 1]);
      // inserting wilayah
      if(count($wilayah) > 0) {
        foreach($wilayah as $wl) {
          $new_wilayah = new SuratPerintahWilayah;
          $new_wilayah->id_surat_perintah = $t->id;
          $new_wilayah->id_wilayah = $wl;
          $new_wilayah->save();
        }
      }



      /*
      DB::table('pkpt_surat_perintah_sasaran')
        ->where('id_surat_perintah', $t->id)
        ->update(['is_deleted' => 1]);

      // insert sasaran
      $sasaran_for_insert = $type == 1 ? $input['sasaran'] : $new_sasaran;

      foreach ($sasaran_for_insert as $idx => $row) {
        $sa = new SuratPerintahSasaran;
        $sa->id_surat_perintah = $t->id;
        $sa->id_sasaran = $row;
        $sa->save();
      }
      */

      DB::commit();
      
    });
    
  }

  public static function delete($id)
  {
    DB::transaction(function () use ($id) {

      SuratPerintah::findOrFail($id)->delete();
      SuratPerintahSasaran::where('id_surat_perintah', $id)->update(['is_deleted' => 1]);
      SuratPerintahAnggota::where('id_surat_perintah', $id)->update(['is_deleted'=> 1]);

      DB::commit();

    });
  }

  /**
   * Get Valid Surat Perintah yang sudah berNomor surat
   */
  public static function get_valid_sp($return_chain = false)
  {
    $data = SuratPerintah::whereRaw(DB::raw("no_surat <> ''"));

    return $return_chain ? $data : $data->get();
  }

  public static function data_for_form($additional_data = [], $id_sp = 0)
  {

    $wilayah = WilayahService::get_data();
    $periode = PeriodeService::get_data();
    $kegiatan = KegiatanService::get_data();
    $program_kerja = ProgramKerjaService::get_program_kerja_by_type_pkpt(1);
    $list_inspektur = PegawaiService::get_current_inspektur($id_sp);
    $unsur = Unsur::where('is_deleted', 0)->get();

    $dasar_surat = DasarSurat::first();

    return array_merge($additional_data, [
      'kegiatan' => $kegiatan,
      'program_kerja' => $program_kerja,
      'wilayah' => $wilayah,
      'dasar_surat' => $dasar_surat,
      'periode' => $periode,
      'list_inspektur' => $list_inspektur,
      'unsur' => $unsur
    ]);
  }

  public static function approve($id)
  {
    $t = SuratPerintah::findOrFail($id);
    $t->is_approve = 1;
    $t->save();

    return $t;
  }
}
