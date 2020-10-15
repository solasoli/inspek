<?php

namespace App\Service\Master;

use DB;
use Auth;
use Illuminate\Validation\Rule;
use App\Repository\Master\Periode;

class PeriodeService
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
          'nama.required' => 'Nama Periode harus diisi!',
          'nama.unique' => 'Nama Periode sudah ada!',
      ];

      return (object) array(
          'rules' => $rules,
          'label' => $label
      );
  }

  public static function create($data)
  {
    $t = new Periode;
    return self::proccess_data($t, $data);
  }

  public static function update($id, $data)
  {
    $t = Periode::findOrFail($id);
    return self::proccess_data($t, $data);
  }

  public static function createOrUpdate($id, $data)
  {
    $t = Periode::findOrNew($id);
    return self::proccess_data($t, $data);
  }

  private static function proccess_data(Periode $kegiatan, $data) {

    DB::transaction(function() use ($kegiatan, $data) {
      $t = $kegiatan;
      $t->nama = $data['nama'];
      $t->save();

      DB::commit();
    });

    return $kegiatan;
  }

  public static function delete($id) {
    $t = Periode::findOrFail($id)->delete();
  }

  public static function get_data($is_deleted = 0)
  {
      return Periode::where("is_deleted", $is_deleted)->get();
  }
}
