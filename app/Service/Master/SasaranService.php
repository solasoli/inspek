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
      'id_program_kerja' => ['required']
    ];

    if ($id == 0) {
      $rules = array_merge(
        $rules,
        ['nama' => [
          'required',
          Rule::unique('mst_sasaran', 'nama')->where(function ($query) {
            return $query->where('is_deleted', 0);
          })

        ]]
      );
    } else {
      $rules = array_merge(
        $rules,
        ['nama' => [
          'required',
          Rule::unique('mst_sasaran', 'nama')->where(function ($query) use ($id) {
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

  private static function proccess_data(Sasaran $sasaran, $data)
  {

    DB::transaction(function () use ($sasaran, $data) {
      $t = $sasaran;
      $t->nama = $data['nama'];
      $t->id_program_kerja = $data['id_program_kerja'];
      $t->save();

      DB::commit();
    });

    return $sasaran;
  }

  public static function delete($id)
  {
    $t = Sasaran::findOrFail($id)->delete();
  }

  public static function delete_by_program_kerja($id_program_kerja)
  {
    $t = Sasaran::where('id_program_kerja', $id_program_kerja)->update(array('is_deleted' => 1));
  }

  public static function get_by_id_sasaran($id_sasaran = 0)
  {
    $data = Sasaran::where('id_sasaran', $id_sasaran)->get();

    return $data;
  }

  public static function get_sasaran_by_id_program_kerja($id = 0)
  {
    $data = Sasaran::where('id_program_kerja', $id)
    ->where('is_deleted', 0)
    ->get();

    return $data;
  }
}
