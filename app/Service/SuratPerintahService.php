<?php

namespace App\Service;

use DB;
use Auth;
use App\Kegiatan;
use App\Sasaran;
use App\SuratPerintah;
use App\SuratPerintahAnggota;
use App\SuratPerintahSasaran;
use App\Service\KegiatanService;

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
        $kegiatan = Kegiatan::findOrFail($input['kegiatan']);
      } else { // Surat Perintah Non PKPT

        // prepare data kegiatan
        $data_kegiatan = [
          'nama' => $input['make_kegiatan'],
          'wilayah' => $input['wilayah'],
          'opd' => $input['opd'],
          'dari' => $input['dari'],
          'sampai' => $input['sampai'],
          'sasaran' => $input['sasaran_kegiatan'],
        ];

        if(isset($sp->id_kegiatan)) {
          $kegiatan = KegiatanService::update($sp->id_kegiatan, $data_kegiatan);
        } else {
          $kegiatan = KegiatanService::create($data_kegiatan, $type);
        }
        
        // insert sasaran kegiatan
        foreach($kegiatan['sasaran'] as $idx => $row){
          $new_sasaran[] = $row->id;
        } 

        $kegiatan = $kegiatan['kegiatan'];
      }


      $data = [
        'dari' => $kegiatan->dari,
        'sampai' => $kegiatan->sampai
      ];

      $t = $sp;
      $t->id_wilayah = $input['wilayah'];
      $t->id_inspektur = $input['inspektur'];
      $t->id_inspektur_pembantu = $input['inspektur_pembantu'];
      $t->id_pengendali_teknis = $input['pengendali_teknis'];
      $t->id_ketua_tim = $input['ketua_tim'];
      $t->id_kegiatan = $kegiatan->id;
      $t->no_surat = '';
      $t->dasar_surat = $input['dasar_surat'];
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
    });
  }

  public static function get_anggota($id_sp, $return_chain = false) {
    $data = DB::table("pkpt_surat_perintah AS sp")
    ->select(DB::raw("p.*"))
    ->join("pkpt_surat_perintah_anggota AS spa", "spa.id_surat_perintah", "=", "sp.id")
    ->join("pgw_pegawai AS p", "p.id", "=", "spa.id_anggota")
    ->where("spa.is_deleted", 0)
    ->where("sp.id", $id_sp);

    return $return_chain ? $data : $data->get();
  }

  public static function get_sasaran($id_sp, $return_chain = false) {
    $data = DB::table("pkpt_surat_perintah AS sp")
    ->select(DB::raw("sa.*"))
    ->join("pkpt_surat_perintah_sasaran AS ssa", "ssa.id_surat_perintah", "=", "sp.id")
    ->join("mst_sasaran AS sa", "sa.id", "=", "ssa.id_sasaran")
    ->where("ssa.is_deleted", 0)
    ->where("sp.id", $id_sp);

    return $return_chain ? $data : $data->get();
  }

}