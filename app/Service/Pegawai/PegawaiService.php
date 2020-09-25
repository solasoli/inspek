<?php

namespace App\Service\Pegawai;

use DB;
use Auth;
use App\Service\Master\SkpdService;
use App\Service\Pegawai\EselonService;
use App\Service\Pegawai\PangkatService;
use App\Service\Pegawai\JabatanService;
use App\Repository\Pegawai\Pegawai;
use App\Service\Master\WilayahService;
use Illuminate\Validation\Rule;

class PegawaiService
{

  public static function get_validation($id = 0)
  {
    $rules = [
      'opd' => 'required',
      'eselon' => 'required',
      'pangkat' => 'required',
      'pangkat_golongan' => 'required',
      'jabatan' => 'required',
      'nama' => 'required',
      'nama_asli' => 'required',
      'jenjab' => 'required',
      'score_angka_credit' => 'required'
    ];

    if ($id == 0) {
      $rules = array_merge(
        $rules,
        [
          'nip' => [
            'required',
            Rule::unique('pgw_pegawai', 'nip')->where(function ($query) {
              return $query->where('is_deleted', 0);
            })
          ]
        ]
      );
    } else {
      $rules = array_merge(
        $rules,
        [
          'nip' => [
            'required',
            Rule::unique('pgw_pegawai', 'nip')->where(function ($query) use ($id) {
              return $query->where('is_deleted', 0)
                ->where("id", "!=", $id);
            })
          ]
        ]
      );
    }

    $label = [
      'opd.required' => 'OPD harus diisi!',
      'eselon.required' => 'Eselon harus diisi!',
      'pangkat.required' => 'Pangkat harus diisi!',
      'pangkat_golongan.required' => 'Pangkat Golongan harus diisi!',
      'jabatan.required' => 'Jabatan harus diisi!',
      'nip.required' => 'NIP harus diisi!',
      'nip.unique' => 'NIP sudah tersedia!',
      'nama.required' => 'Nama harus diisi!',
      'nama_asli.required' => 'Nama Asli harus diisi!',
      'jenjab.required' => 'Jenjang Jabatan harus diisi!',
      'score_angka_credit.required' => 'Score Angka Credit harus diisi!',
    ];

    return (object) array(
      'rules' => $rules,
      'label' => $label
    );
  }

  public static function create($data)
  {
    $t = new Pegawai;
    return self::proccess_data($t, $data);
  }

  public static function update($id, $data)
  {
    $t = Pegawai::findOrFail($id);
    return self::proccess_data($t, $data);
  }

  public static function createOrUpdate($id, $data)
  {
    $t = Pegawai::findOrNew($id);
    return self::proccess_data($t, $data);
  }

  private static function proccess_data(Pegawai $pegawai, $data)
  {

    DB::transaction(function () use ($pegawai, $data) {
      $t = $pegawai;
      $t->id_skpd = $data['opd'];
      $t->id_eselon = $data['eselon'];
      $t->id_pangkat = $data['pangkat'];
      $t->id_pangkat_golongan = $data['pangkat_golongan'];
      $t->id_jabatan = $data['jabatan'];
      $t->id_peran = 0; // ini diisi di menu struktur
      $t->id_wilayah = 0; // ini diisi di menu struktur
      $t->nip = $data['nip'];
      $t->nama = $data['nama'];
      $t->nama_asli = $data['nama_asli'];
      $t->jenjab = $data['jenjab'];
      $t->score_angka_credit = $data['score_angka_credit'];
      $t->is_deleted = 0;
      $t->save();

      DB::commit();
    });

    return $pegawai;
  }

  public static function get_anggota($return_chain = false, $wilayah = null)
  {
    $data = DB::table("pgw_pegawai AS p")
      ->select(DB::raw("p.id, p.nama, p.id_jabatan, j.name AS jabatan, p.atasan_langsung"))
      ->join("pgw_jabatan AS j", "p.id_jabatan", "=", "j.id")
      ->join("pgw_eselon AS e", "p.id_eselon", "=", "e.id")
      ->join("mst_wilayah AS w", "p.id_wilayah", "=", "w.id")
      ->leftJoin("pgw_peran_jabatan AS ppj", "ppj.id_jabatan", "=", "p.id_jabatan")
      ->leftJoin("pgw_peran AS pp", "pp.id", "=", "ppj.id_peran")
      ->whereRaw(DB::raw("e.level >= 3"))
      ->where('p.is_deleted', 0)
      ->whereRaw(DB::raw("pp.kode NOT IN ('sekretaris','wakil_sekretaris')"))
      ->groupBy("p.id", "p.nama", "p.id_jabatan", "j.name", "p.atasan_langsung");

    if ($wilayah >= 0 && $wilayah !== null) {
      $data = $data->where("w.id", $wilayah);
    }

    return $return_chain ? $data : $data->get();
  }

  public static function delete($id)
  {
    $t = Pegawai::findOrFail($id)->delete();
  }

  public static function data_for_form($additional_data = [])
  {

    $opd = SkpdService::get_data();
    $eselon = EselonService::get_data();
    $pangkat = PangkatService::get_data();
    $pangkat_golongan = PangkatGolonganService::get_data();
    $jabatan = JabatanService::get_data();
    $wilayah = WilayahService::get_data();

    return array_merge($additional_data, [
      'opd' => $opd,
      'eselon' => $eselon,
      'pangkat' => $pangkat,
      'pangkat_golongan' => $pangkat_golongan,
      'jabatan' => $jabatan,
      'wilayah' => $wilayah,
    ]);
  }
}
