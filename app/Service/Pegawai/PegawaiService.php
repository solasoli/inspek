<?php

namespace App\Service\Pegawai;


use Illuminate\Support\Facades\DB;
use Auth;
use App\Service\Master\SkpdService;
use App\Service\Pegawai\EselonService;
use App\Service\Pegawai\PangkatService;
use App\Service\Pegawai\JabatanService;
use App\Service\Pegawai\PeranService;
use App\Repository\Pegawai\Pegawai;
use App\Service\Master\WilayahService;
use Illuminate\Validation\Rule;
use App\Repository\Pegawai\PeranJabatan;
use App\Repository\SuratPerintah\SuratPerintah;

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
      'wilayah.required' => 'Irban harus diisi!',
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
      $t->id_wilayah = $data['wilayah']; // ini diisi di menu struktur
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
    // get peran yang bukan inspektur dan sekretaris
    $excludePeran = PeranService::get_specific_role_by_code([]);

    // get id jabatan by id peran
    $listPeranJabatan = PeranJabatan::whereIn('id_peran', $excludePeran->map(function ($ep) {
      return $ep->id;
    }))->get();

    $data = Pegawai::with([
      'eselon' => function ($query) {
        $query->whereRaw(DB::raw('level >= 3'));
      }
    ]);

    $data->with([
      'wilayah' => function ($query) use ($wilayah) {
        if ($wilayah >= 0 && $wilayah !== null) {
          $query->whereIn("id", $wilayah);
        }
      }
    ]);

    $data->with('jabatan');
    $data->whereNotIn('id_jabatan', $listPeranJabatan->map(function ($rw) {
      return $rw->id_jabatan;
    }));

    return $return_chain ? $data : $data->get();
  }

  
  public static function get_anggota_sort_by_jabatan($return_chain = false, $wilayah = null)
  {
    // get peran yang bukan inspektur dan sekretaris
    $excludePeran = PeranService::get_specific_role_by_code([]);

    // get id jabatan by id peran
    $listPeranJabatan = PeranJabatan::whereIn('id_peran', $excludePeran->map(function ($ep) {
      return $ep->id;
    }))->get();

    $data = Pegawai::with([
      'eselon' => function ($query) {
        $query->whereRaw(DB::raw('level >= 3'));
      }
    ])
    ->orderByRaw('id_jabatan = 29 DESC, id_jabatan = 56 DESC, id_jabatan = 49 DESC, id_jabatan = 74 DESC, id_jabatan = 36 DESC');

    $data->with([
      'wilayah' => function ($query) use ($wilayah) {
        if ($wilayah >= 0 && $wilayah !== null) {
          $query->whereIn("id", $wilayah);
        }
      }
    ]);

    $data->with('jabatan');
    $data->whereNotIn('id_jabatan', $listPeranJabatan->map(function ($rw) {
      return $rw->id_jabatan;
    }));

    return $return_chain ? $data : $data->get();
  }

  public static function delete($id)
  {
    return Pegawai::findOrFail($id)->delete();
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

  public static function change_atasan_langsung($id_pegawai, $id_atasan_langsung)
  {

    DB::transaction(function () use ($id_pegawai, $id_atasan_langsung) {

      $t = Pegawai::findOrFail($id_pegawai);

      $t->atasan_langsung = $id_atasan_langsung;
      // $t->id_wilayah = $id_atasan_langsung;
      $t->save();

      DB::commit();
    });
  }

  public static function get_current_inspektur($id_sp = 0)
  {

    $list_inspektur = self::get_pegawai_by_peran(['inspektur']);

    if ($id_sp > 0) {
      $get_inspektur_from_sp = SuratPerintah::find($id_sp);
      $list_inspektur = $list_inspektur->orWhere("id", $get_inspektur_from_sp != null ? $get_inspektur_from_sp->id_inspektur : 0);
    }

    $list_inspektur = $list_inspektur->get();

    return $list_inspektur;
  }

  public static function get_inspektur_pembantu_by_wilayah($id_wilayah = 0)
  {
    $pegawai = self::get_pegawai_by_peran(['inspektur_pembantu']);

    return $pegawai->whereIn('id_wilayah', $id_wilayah)->get();
  }

  public static function get_pengendali_teknis_by_wilayah($id_wilayah)
  {
    $pegawai = self::get_pegawai_by_peran(['pengendali_teknis']);

    if ($id_wilayah != 'all') {
      $pegawai = $pegawai->whereIn("id_wilayah", $id_wilayah);
    }
    return $pegawai->get();
  }

  public static function get_ketua_tim_by_wilayah($id_wilayah)
  {
    $pegawai = self::get_pegawai_by_peran(['ketua_tim']);

    if ($id_wilayah != 'all') {
      $pegawai = $pegawai->whereIn("id_wilayah", $id_wilayah);
    }
    return $pegawai->get();
  }

  public static function get_pegawai_by_peran($role = [])
  {

    $pegawai = Pegawai::whereHas('jabatan', function ($q) use ($role) {
      $q->whereHas('peran', function ($qj) use ($role) {
        $qj->whereIn('kode', $role);
      });
    });

    return $pegawai;
  }
}
