<?php

namespace App\Service;

use DB;
use Auth;
use App\Pegawai;

class PegawaiService
{

  public static function create($data, $type_pkpt = 1) {
      // return self::proccess_data()
  }

  public static function update($id_kegiatan, $data) {
      // return self::proccess_data()
  }

  private static function proccess_data(Pegawai $pegawai, $data) {

    DB::transaction(function() use ($pegawai, $data) {
    });
  }

  public static function get_anggota($return_chain = false, $wilayah = null) {
      $data = DB::table("pgw_pegawai AS p")
      ->select(DB::raw("p.id, p.nama, p.id_jabatan, j.name AS jabatan, p.atasan_langsung"))
      ->join("pgw_jabatan AS j", "p.id_jabatan", "=", "j.id")
      ->join("pgw_eselon AS e", "p.id_eselon", "=", "e.id")
      ->join("mst_wilayah AS w", "p.id_wilayah", "=", "w.id")
      ->leftJoin("pgw_peran_jabatan AS ppj", "ppj.id_jabatan", "=","p.id_jabatan")
      ->leftJoin("pgw_peran AS pp", "pp.id", "=","ppj.id_peran")
      ->whereRaw(DB::raw("e.level >= 3"))
      ->where('p.is_deleted', 0)
      ->whereRaw(DB::raw("pp.kode NOT IN ('sekretaris','wakil_sekretaris')"))
      ->groupBy("p.id", "p.nama", "p.id_jabatan", "j.name", "p.atasan_langsung");

      if($wilayah >= 0 && $wilayah != null) {
        $data = $data->where("w.id", $wilayah);
      } 

      return $return_chain ? $data : $data->get();   
  }

}