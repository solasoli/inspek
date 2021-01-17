<?php

namespace App\Service\Master;

use DB;
use Auth;
use App\Repository\Master\Kegiatan;
use App\Repository\Master\ProgramKerja;
use App\Repository\Master\ProgramKerjaJenisPengawasan;
use App\Repository\Master\ProgramKerjaSkpd;
use App\Repository\Master\ProgramKerjaWilayah;
use App\Repository\Master\Sasaran;
use App\Repository\Master\Skpd;
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
      // $t->sub_kegiatan = $data['sub_kegiatan'];
      // $t->id_wilayah = $data['wilayah'];
      // $t->id_skpd = $data['opd'];

      if (isset($data['type_pkpt'])) {
        $t->type_pkpt = $data['type_pkpt'];
      }

      $t->dari = $use['dari'] . ' 00:00:00';
      $t->sampai = $use['sampai'] . ' 00:00:00';
      $t->id_kegiatan = $data['kegiatan'];
      // $t->anggaran = str_replace('.', '', $data['anggaran']);
      $t->sasaran = $data['sasaran'];
      $t->jml_wakil_penanggung_jawab = $data['jml_wakil_penanggung_jawab'];
      $t->jml_pengendali_teknis = $data['jml_pengendali_teknis'];
      $t->jml_ketua_tim = $data['jml_ketua_tim'];
      $t->jml_anggota = $data['jml_anggota'];
      $t->is_all_opd = isset($data['all_opd']) && $data['all_opd'] == 1 ? 1 : 0;
      $jml_power = $t->jml_wakil_penanggung_jawab + $t->jml_pengendali_teknis + $t->jml_ketua_tim + $t->jml_anggota;
      $t->jml_man_power = $jml_power;
      $t->created_at = date('Y-m-d H:i:s');
      $t->created_by = Auth::id();
      $t->is_lintas_irban = isset($data['lintas_irban']) && $data['lintas_irban'] == 1 ? 1 : 0;
      $t->save();

      // SasaranService::delete_by_program_kerja($t->id);
 
      // foreach ($data['sasaran'] as $v) {
      //   $data_sasaran = [
      //     'nama' => $v,
      //     'id_program_kerja' => $t->id
      //   ];
      //   $t2 = SasaranService::create($data_sasaran);
      // }

      // update dari & sampai surat perintah
      SuratPerintah::where('id_program_kerja', $t->id)->update(['dari' => $t->dari, 'sampai' => $t->sampai]);

      ProgramKerjaWilayah::where('id_program_kerja', $t->id)->update(['is_deleted' => 1]);
      // insert wilayah
      if(isset($data['wilayah'])) {
        foreach ($data['wilayah'] as $v) {
          $wilayah = new ProgramKerjaWilayah;
          $wilayah->id_wilayah = $v;
          $wilayah->id_program_kerja = $t->id;
          $wilayah->save();
        }
      }

      
      ProgramKerjaSkpd::where('id_program_kerja', $t->id)->update(['is_deleted' => 1]);

      if(isset($data['all_opd']) && $data['all_opd'] == 1) {
        if($t->is_lintas_irban == 1) { 
          $skpd = Skpd::where('is_deleted', 0)->get();
        } else {
          $skpd = Skpd::whereIn('id_wilayah', $wilayah)->where('is_deleted', 0)->get();
        }
        foreach ($skpd as $v) {
          $wilayah = new ProgramKerjaSkpd();
          $wilayah->id_skpd = $v->id;
          $wilayah->id_program_kerja = $t->id;
          $wilayah->save();
        }
      } else {
        // insert SKPD
        if(isset($data['opd'])) {
          foreach ($data['opd'] as $v) {
            $wilayah = new ProgramKerjaSkpd();
            $wilayah->id_skpd = $v;
            $wilayah->id_program_kerja = $t->id;
            $wilayah->save();
          }
        }
      }

      
      ProgramKerjaJenisPengawasan::where('id_program_kerja', $t->id)->update(['is_deleted' => 1]);
      // insert Jenis Pengawasan
      if(isset($data['jenis_pengawasan'])) {
        foreach ($data['jenis_pengawasan'] as $v) {
          $wilayah = new ProgramKerjaJenisPengawasan();
          $wilayah->id_jenis_pengawasan = $v;
          $wilayah->id_program_kerja = $t->id;
          $wilayah->save();
        }
      }

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
    $data = ProgramKerja::where("is_deleted", 0)
      ->where('type_pkpt', $type_pkpt)
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
