<?php

namespace App\Service\Master;

use DB;
use Auth;
use Illuminate\Validation\Rule;
use App\Repository\Master\Kegiatan;

class KegiatanService
{
  public static function create($data)
  {
    $t = new Kegiatan;
    return self::proccess_data($t, $data);
  }

  public static function update($id, $data)
  {
    $t = Kegiatan::findOrFail($id);
    return self::proccess_data($t, $data);
  }

  public static function createOrUpdate($id, $data)
  {
    $t = Kegiatan::findOrNew($id);
    return self::proccess_data($t, $data);
  }

  private static function proccess_data(Kegiatan $kegiatan, $data) {

    DB::transaction(function() use ($kegiatan, $data) {
      $t = $kegiatan;
      $t->nama = $data['nama'];
      $t->save();

      DB::commit();
    });

    return $kegiatan;
  }

  public static function delete($id) {
    $t = Kegiatan::findOrFail($id)->delete();
  }

  public static function get_data() {
    $data = Kegiatan::all();

    return $data;
  }

  public static function get_kegiatan_by_type_pkpt($type_pkpt = 1) {
    $data = DB::table("mst_program_kerja AS pk")
    ->select(DB::raw("k.id, k.nama AS kegiatan,
      pk.id AS id_pk,
      pk.sub_kegiatan AS nama,
      pk.dari,
      pk.sampai,
      pk.id_wilayah"))
    ->join("mst_kegiatan AS k", "pk.id_kegiatan","=","k.id")
    ->where("pk.is_deleted", 0)
    ->where("k.is_deleted", 0)
    ->where('pk.type_pkpt', $type_pkpt)
    ->get();

    return $data;
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
