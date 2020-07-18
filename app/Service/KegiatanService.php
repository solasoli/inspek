<?php

namespace App\Service;

use DB;
use Auth;
use App\Kegiatan;
use App\Sasaran;

class KegiatanService
{

  public static function create($data, $type_pkpt = 1) {

    $t = new Kegiatan;
    $data['type_pkpt'] = $type_pkpt;
    return self::proccess_data($t, $data);
  }

  public static function update($id_kegiatan, $data) {

    $t = Kegiatan::findOrFail($id_kegiatan);
    return self::proccess_data($t, $data);
  }

  public static function createOrUpdate($id_kegiatan, $data) {

    $t = Kegiatan::findOrNew($id_kegiatan);
    return self::proccess_data($t, $data);
  }

  private static function proccess_data(Kegiatan $kegiatan, $data) {

    DB::transaction(function() use ($kegiatan, $data) {

      $dari = explode('-', $data['dari']);
      $dari = $dari[2].'-'.$dari[1].'-'.$dari[0];
      $sampai = explode('-', $data['sampai']);
      $sampai = $sampai[2].'-'.$sampai[1].'-'.$sampai[0];

      $use = [
        'dari' => $dari,
        'sampai' => $sampai
      ];

      $t = $kegiatan;
      $t->nama = $data['nama'];
      // $t->id_wilayah = $data['wilayah'];
      $t->id_skpd = $data['opd'];
      $t->id_program_kerja = $data['program_kerja'];

      // if(isset($data['type_pkpt'])) {
      //   $t->type_pkpt = $data['type_pkpt'];
      // }
      
      // $t->dari = $use['dari'].' 00:00:00';
      // $t->sampai = $use['sampai'].' 00:00:00';
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
      // DB::table('pkpt_surat_perintah')
      // ->where('id_kegiatan', $t->id)
      // ->update(['dari' => $t->dari, 'sampai' => $t->sampai]);
      
      DB::commit();
    });

    return [
      'kegiatan' => $kegiatan,
      'sasaran' => Sasaran::where("is_deleted", 0)->where("id_kegiatan", $kegiatan->id)->get()
    ];
  }

  public static function delete($id) {
    $t = Kegiatan::findOrFail($id);
    $t->deleted_at = date('Y-m-d H:i:s');
    $t->deleted_by = Auth::id();
    $t->is_deleted = 1;
    $t->save();

    DB::table('mst_sasaran')
    ->where('id_kegiatan', $id)
    ->update(['is_deleted' => 1]);
  }

  public static function get_kegiatan_by_type_pkpt($type_pkpt = 1) {
    $data = DB::table("mst_program_kerja AS pk")
    ->select(DB::raw("k.*,pk.dari,pk.sampai,pk.id_wilayah"))
    ->join("mst_kegiatan AS k", "pk.id","=","k.id_program_kerja")
    ->where("pk.is_deleted", 0)
    ->where("k.is_deleted", 0)
    ->where('pk.type_pkpt', $type_pkpt)
    ->get();

    return $data;
  }

  public static function delete_by_program_kerja($id_program_kerja) {
    $t = Kegiatan::where('id_program_kerja', $id_program_kerja)->get();
    foreach($t as $idx => $row) {
      Self::delete($row->id);
    }
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