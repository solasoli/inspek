<?php

namespace App\Service\Master;

use DB;
use Auth;
use App\Repository\Master\Kegiatan;
use App\Repository\Master\ProgramKerja;
use App\Repository\Master\Sasaran;
use App\Repository\SuratPerintah\SuratPerintah;
use App\Service\Master\KegiatanService;

class ProgramKerjaService
{

  public static function create($data, $type_pkpt = 1)
  {

    $t = new ProgramKerja;
    $data['type_pkpt'] = $type_pkpt;
    return self::proccess_data($t, $data);
  }

  public static function update($id_kegiatan, $data)
  {

    $t = ProgramKerja::findOrFail($id_kegiatan);
    return self::proccess_data($t, $data);
  }

  private static function proccess_data(ProgramKerja $program_kerja, $data)
  {

    $result = DB::transaction(function () use ($program_kerja, $data) {

      $dari = explode('-', $data['dari']);
      $dari = $dari[2] . '-' . $dari[1] . '-' . $dari[0];
      $sampai = explode('-', $data['sampai']);
      $sampai = $sampai[2] . '-' . $sampai[1] . '-' . $sampai[0];

      $use = [
        'dari' => $dari,
        'sampai' => $sampai
      ];

      $t = $program_kerja;
      $t->sub_kegiatan = $data['sub_kegiatan'];
      $t->id_wilayah = $data['wilayah'];
      $t->id_skpd = $data['opd'];

      if (isset($data['type_pkpt'])) {
        $t->type_pkpt = $data['type_pkpt'];
      }

      $t->dari = $use['dari'] . ' 00:00:00';
      $t->sampai = $use['sampai'] . ' 00:00:00';
      $t->id_kegiatan = $data['kegiatan'];
      $t->anggaran = str_replace('.', '', $data['anggaran']);
      $t->jml_wakil_penanggung_jawab = $data['jml_wakil_penanggung_jawab'];
      $t->jml_pengendali_teknis = $data['jml_pengendali_teknis'];
      $t->jml_ketua_tim = $data['jml_ketua_tim'];
      $t->jml_anggota = $data['jml_anggota'];
      $jml_power = $t->jml_wakil_penanggung_jawab + $t->jml_pengendali_teknis + $t->jml_ketua_tim + $t->jml_anggota;
      $t->jml_man_power = $jml_power;
      $t->created_at = date('Y-m-d H:i:s');
      $t->created_by = Auth::id();
      $t->save();

      SasaranService::delete_by_program_kerja($t->id);

      foreach ($data['sasaran'] as $v) {
        $data_sasaran = [
          'nama' => $v,
          'id_program_kerja' => $t->id
        ];
        $t2 = SasaranService::create($data_sasaran);
      }

      // update dari & sampai surat perintah
      SuratPerintah::where('id_program_kerja', $t->id)->update(['dari' => $t->dari, 'sampai' => $t->sampai]);
      DB::commit();

      return $program_kerja;
    });

    return $result;
  }

  // mengambil kegiatan yang di sort berdasarkan
  public static function get_kegiatan_sort_by_empty_sp($return_chain = false)
  {
    $data = DB::table("mst_kegiatan AS k")
      ->select("k.*")
      ->leftJoin("pkpt_surat_perintah AS sp", "sp.id_kegiatan", "k.id")
      ->where("k.is_deleted", 0)
      ->groupBy("k.id")
      ->get();
  }

  public static function get_program_kerja_by_type_pkpt($type_pkpt = 1)
  {
    $data = DB::table("mst_program_kerja AS pk")
      ->select(DB::raw("k.id AS id_kegiatan, k.nama AS kegiatan,
      pk.id,
      pk.sub_kegiatan AS nama,
      pk.dari,
      pk.sampai,
      pk.id_wilayah"))
      ->join("mst_kegiatan AS k", "pk.id_kegiatan", "=", "k.id")
      ->where("pk.is_deleted", 0)
      ->where("k.is_deleted", 0)
      ->where('pk.type_pkpt', $type_pkpt)
      ->get();

    return $data;
  }

  public static function get_by_id($id = 0)
  {
    $data = DB::table("mst_program_kerja AS pk")
      ->select(DB::raw(
        "k.id AS id_kegiatan, k.nama AS nama_kegiatan,
      pk.id, pk.sub_kegiatan, pk.dari,
      pk.sampai, pk.id_skpd, pk.id_wilayah,
      pk.anggaran"
      ))
      ->join("mst_kegiatan AS k", "pk.id_kegiatan", "=", "k.id")
      ->where("pk.is_deleted", 0)
      ->where("k.is_deleted", 0)
      ->where('pk.id', $id)
      ->first();

    return $data;
  }
}
