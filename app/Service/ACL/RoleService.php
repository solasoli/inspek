<?php

namespace App\Service\ACL;

use DB;
use Auth;
use App\Repository\ACL\Role;

class RoleService
{
  public static function create($data)
  {
    $t = new Role;
    return self::proccess_data($t, $data);
  }

  public static function update($id, $data)
  {
    $t = Role::findOrFail($id);
    return self::proccess_data($t, $data);
  }

  public static function createOrUpdate($id, $data)
  {
    $t = Role::findOrNew($id);
    return self::proccess_data($t, $data);
  }

  private static function proccess_data(Role $role, $data) {

    DB::transaction(function() use ($role, $data) {
      $t = $role;
      $t->nama = $data['nama'];
      $t->save();

      DB::commit();
    });

    return $role;
  }

  public static function delete($id) {
    $t = Role::findOrFail($id)->delete();
  }

}
