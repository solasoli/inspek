<?php

namespace App\Service\ACL;

use DB;
use Hash;
use App\User;

class UserService
{
  public static function create($data)
  {
    $t = new User;
    $cat = 1;
    return self::proccess_data($t, $data, $cat);
  }

  public static function update($id, $data)
  {
    $t = User::findOrFail($id);
    $cat = 2;
    return self::proccess_data($t, $data, $cat);
  }

  private static function proccess_data(User $user, $data, $cat) {

    DB::transaction(function() use ($user, $data, $cat) {
      $t = $user;
      $t->username = $data['username'];
      $t->email = $data['email'];
      $t->id_role = $data['role'];
      $t->is_deleted = 0;

      if($cat > 1) { // update
        if($data['password'] != '') { // jika password diganti
          $t->password = Hash::make($data['password']);
        }
      } else { // create
        $t->password = Hash::make($data['password']);
      }

      $t->save();

      DB::commit();
    });

    return $user;
  }

  public static function delete($id) {
    $t = User::findOrFail($id);
    $t->is_deleted = 1;
    $t->save();
  }

}
