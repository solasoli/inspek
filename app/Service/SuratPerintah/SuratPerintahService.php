<?php

namespace App\Service\SuratPerintah;

use DB;
use Auth;
use App\Repository\Master\Kegiatan;
use App\Repository\SuratPerintah\SuratPerintah;
use App\Repository\SuratPerintah\SuratPerintahAnggota;
use App\Repository\SuratPerintah\SuratPerintahSasaran;
use App\Repository\Master\ProgramKerja;
use App\Service\KegiatanService;
use App\Service\Master\ProgramKerjaService;
use App\Service\Master\PeriodeService;
use App\Service\Master\WilayahService;
use App\Service\Pegawai\PegawaiService;

use App\Repository\Master\DasarSurat;

class SuratPerintahService
{

  public static function create($data, $type_pkpt = 1) {
    $t = new SuratPerintah;
    $data['type'] = $type_pkpt;
    return self::proccess_data($t, $data);
  }

  public static function update($id_sp, $data) {
    $t = SuratPerintah::findOrFail($id_sp);
    $data['type'] = $t->is_pkpt;
    return self::proccess_data($t, $data);
  }

  private static function proccess_data(SuratPerintah $sp, $data) {

    DB::transaction(function () use($sp, $data) {

      $type = $data['type'];
      $input = $data;
      $new_sasaran = [];

      if ($type == 1) { // Surat Perintah PKPT
        $program_kerja = ProgramKerja::findOrFail($input['program_kerja']);
        $kegiatan = Kegiatan::findOrFail($program_kerja->id_kegiatan);
      } else { // Surat Perintah Non PKPT

        // prepare data kegiatan
        $data_kegiatan = [
          'nama' => $input['make_kegiatan'],
          'wilayah' => $input['wilayah'],
          'opd' => $input['opd'],
          'dari' => $input['dari'],
          'sampai' => $input['sampai'],
          'sasaran' => $input['sasaran_kegiatan'],
          'sub_kegiatan' => $input['make_sub_kegiatan'],
          'anggaran' => $input['anggaran'],
          'jml_wakil_penanggung_jawab' => 1,
          'jml_pengendali_teknis' => 1,
          'jml_ketua_tim' => 1,
          'jml_anggota' => 1
        ];

        $kegiatan = null;
        $sasaran = [];
        if(isset($sp->id_program_kerja)) {
          $update_kegiatan = KegiatanService::update($sp->id_kegiatan, $data_kegiatan);
          $data_kegiatan['kegiatan'] = $update_kegiatan['kegiatan']->id;
          $kegiatan = $data_kegiatan['kegiatan'];
          $sasaran = $update_kegiatan['sasaran'];

          $program_kerja = ProgramKerjaService::update($sp->id_program_kerja, $data_kegiatan);
        } else {
          // buat kegiatan
          $make_kegiatan = KegiatanService::create($data_kegiatan, $type);
          $data_kegiatan['kegiatan'] = $make_kegiatan['kegiatan']->id;
          $kegiatan = $data_kegiatan['kegiatan'];
          $sasaran = $make_kegiatan['sasaran'];
          $program_kerja = ProgramKerjaService::create($data_kegiatan, $type);
        }


        // insert to pkpt sasaran surat perintah
        foreach($sasaran as $idx => $row){
          $new_sasaran[] = $row->id;
        }
      }

      $dari = explode('-', $input['dari']);
      $dari = $dari[2].'-'.$dari[1].'-'.$dari[0];
      $sampai = explode('-', $input['sampai']);
      $sampai = $sampai[2].'-'.$sampai[1].'-'.$sampai[0];

      $data = [
        'dari' => $dari,
        'sampai' => $sampai
      ];

      $t = $sp;
      $t->id_wilayah = $input['wilayah'];
      $t->id_inspektur = $input['inspektur'];
      $t->id_inspektur_pembantu = $input['inspektur_pembantu'];
      $t->id_pengendali_teknis = $input['pengendali_teknis'];
      $t->id_ketua_tim = $input['ketua_tim'];
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
      $t->save();

      DB::table('pkpt_surat_perintah_anggota')
      ->where('id_surat_perintah', $t->id)
      ->update(['is_deleted' => 1]);

      // insert anggota
      foreach($input['anggota'] as $idx => $row){
        $na = new SuratPerintahAnggota;
        $na->id_surat_perintah = $t->id;
        $na->id_anggota = $row;
        $na->save();
      }


      DB::table('pkpt_surat_perintah_sasaran')
      ->where('id_surat_perintah', $t->id)
      ->update(['is_deleted' => 1]);

      // insert sasaran
      $sasaran_for_insert = $type == 1 ? $input['sasaran'] : $new_sasaran;

      foreach($sasaran_for_insert as $idx => $row){
        $sa = new SuratPerintahSasaran;
        $sa->id_surat_perintah = $t->id;
        $sa->id_sasaran = $row;
        $sa->save();
      }


      DB::commit();
    });
  }

  /**
   * Get Valid Surat Perintah yang sudah bernomer surat
   */
  public static function get_valid_sp($return_chain = false) {
    $data = SuratPerintah::whereRaw(DB::raw("no_surat <> ''"));

    return $return_chain ? $data : $data->get();
  }

  public static function data_for_form($additional_data = [], $id_sp = 0)
  {

    $wilayah = WilayahService::get_data();
    $periode = PeriodeService::get_data();
    $program_kerja = ProgramKerjaService::get_program_kerja_by_type_pkpt(1);
    $list_inspektur = PegawaiService::get_current_inspektur($id_sp);

    $dasar_surat = DasarSurat::first();

    return array_merge($additional_data, [
      'program_kerja' => $program_kerja,
      'wilayah' => $wilayah,
      'dasar_surat' => $dasar_surat,
      'periode' => $periode,
      'list_inspektur' => $list_inspektur,
    ]);
  }

}