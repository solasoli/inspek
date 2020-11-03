<?php

namespace App\Service\Pemeriksaan;

use DB;
use Auth;
use App\Repository\Pemeriksaan\PenentuanSasaranTujuan;

class PenentuanSasaranTujuanService
{

  public static function createOrUpdate($id, $data) // $id = id_surat_perintah
  {
    DB::transaction(function() use ($id, $data) {

      $check = PenentuanSasaranTujuan::where('id_surat_perintah', $id)
      ->where('is_deleted', 0)
      ->first();

      if ($check != '') {
        PenentuanSasaranTujuan::where('id_surat_perintah', $id)
        ->update(['is_deleted' => 1]);
      }
      else {
        // ...
      }

      self::proccess_data($id, $data);
      DB::commit();

    });
  }

  private static function proccess_data($id, $data)
  {
    DB::transaction(function() use ($id, $data) {

      foreach ($data['sasaran_tujuan'] as $key => $val) {
        $t = new PenentuanSasaranTujuan;
        $t->id_surat_perintah = $id;
        $t->id_sasaran_tujuan = $key;
        $t->isi = $val;
        $t->created_at = date('Y-m-d H:i:s');
        $t->created_by = Auth::id();
        $t->save();
      }

      DB::commit();
    });
  }

}
