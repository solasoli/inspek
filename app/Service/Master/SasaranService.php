<?php

namespace App\Service\Master;

use DB;
use Auth;
use Illuminate\Validation\Rule;
use App\Repository\Master\Sasaran;

class SasaranService
{
  public static function get_validation($id = 0)
  {
      $rules = [
          'nama' => ['required']
      ];

      if ($id == 0) {
          $rules = array_merge(
              $rules,
              ['nama' => [
                  'required',
                  Rule::unique('mst_kegiatan', 'nama')->where(function ($query) {
                      return $query->where('is_deleted', 0);
                  })

              ]]
          );
      } else {
          $rules = array_merge(
              $rules,
              ['nama' => [
                  'required',
                  Rule::unique('mst_kegiatan', 'nama')->where(function ($query) use ($id) {
                      return $query->where('is_deleted', 0)->where("id", "!=", $id);
                  })

              ]]
          );
      }

      $label = [
          'nama.required' => 'Nama Sasaran harus diisi!',
          'nama.unique' => 'Nama Sasaran sudah ada!',
      ];

      return (object) array(
          'rules' => $rules,
          'label' => $label
      );
  }

  public static function create($data)
  {
    $t = new Sasaran;
    return self::proccess_data($t, $data);
  }

  public static function update($id, $data)
  {
    $t = Sasaran::findOrFail($id);
    return self::proccess_data($t, $data);
  }

  public static function createOrUpdate($id, $data)
  {
    $t = Sasaran::findOrNew($id);
    return self::proccess_data($t, $data);
  }

  private static function proccess_data(Sasaran $kegiatan, $data) {

    DB::transaction(function() use ($kegiatan, $data) {
      $t = $kegiatan;
      $t->nama = $data['nama'];
      $t->save();

      DB::commit();
    });

    return $kegiatan;
  }

  public static function delete($id) {
    $t = Sasaran::findOrFail($id)->delete();
  }

  public static function get_by_id_kegiatan($id_kegiatan = 0) {
    $data = Sasaran::where('id_kegiatan', $id_kegiatan)->get();

    return $data;
  }

}
