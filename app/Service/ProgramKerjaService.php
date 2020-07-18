<?php

namespace App\Service;

use DB;
use Auth;
use App\Kegiatan;
use App\ProgramKerja;
use App\Sasaran;
use App\Service\KegiatanService;

class ProgramKerjaService
{

  public static function create($data, $type_pkpt = 1) {

    $t = new ProgramKerja;
    $data['type_pkpt'] = $type_pkpt;
    return self::proccess_data($t, $data);
  }

  public static function update($id_kegiatan, $data) {

    $t = ProgramKerja::findOrFail($id_kegiatan);
    return self::proccess_data($t, $data);
  }

  private static function proccess_data(ProgramKerja $program_kerja, $data) {

    $kegiatan = null;
    DB::transaction(function() use ($program_kerja, $data, $kegiatan) {

      $dari = explode('-', $data['dari']);
      $dari = $dari[2].'-'.$dari[1].'-'.$dari[0];
      $sampai = explode('-', $data['sampai']);
      $sampai = $sampai[2].'-'.$sampai[1].'-'.$sampai[0];

      $use = [
        'dari' => $dari,
        'sampai' => $sampai
      ];

      $t = $program_kerja;
      $t->nama = $data['nama'];
      $t->id_wilayah = $data['wilayah'];
      $t->id_skpd = $data['opd'];

      if(isset($data['type_pkpt'])) {
        $t->type_pkpt = $data['type_pkpt'];
      }
      
      $t->dari = $use['dari'].' 00:00:00';
      $t->sampai = $use['sampai'].' 00:00:00';
      $t->created_at = date('Y-m-d H:i:s');
      $t->created_by = Auth::id();
      $t->save();

      DB::table('mst_sasaran')
      ->where('id_kegiatan', $t->id)
      ->update(['is_deleted' => 1]);

      foreach($data['sasaran'] AS $i => $v){
        $t2 = new Sasaran;
        $t2->nama = $v;
        $t2->id_kegiatan = $t->id;
        $t2->save();
      }

      // update dari & sampai surat perintah
      DB::table('pkpt_surat_perintah')
      ->where('id_program_kerja', $t->id)
      ->update(['dari' => $t->dari, 'sampai' => $t->sampai]);
      
      // buat kegiatan
      $data['program_kerja'] = $t->id;
      $kegiatan = KegiatanService::createOrUpdate($t->id, $data);

      DB::commit();
    });

    return [
      'program_kerja' => $program_kerja,
      'kegiatan' => $kegiatan['kegiatan'],
      'sasaran' => $kegiatan['sasaran']
    ];
  }

  // mengambil kegiatan yang di sort berdasarkan
  public static function get_kegiatan_sort_by_empty_sp($return_chain = false) {
    $data = DB::table("mst_kegiatan AS k")
    ->select("k.*")
    ->leftJoin("pkpt_surat_perintah AS sp", "sp.id_kegiatan", "k.id")
    ->where("k.is_deleted", 0)
    ->groupBy("k.id")
    ->get();
  }

}