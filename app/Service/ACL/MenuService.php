<?php

namespace App\Service\ACL;

use DB;
use Auth;
use App\Repository\ACL\Menu;

class MenuService
{
  public static function create($data)
  {
    $t = new Menu;
    return self::proccess_data($t, $data);
  }

  public static function update($id, $data)
  {
    $t = Menu::findOrFail($id);
    return self::proccess_data($t, $data);
  }

  public static function createOrUpdate($id, $data)
  {
    $t = Menu::findOrNew($id);
    return self::proccess_data($t, $data);
  }

  private static function proccess_data(Menu $menu, $data) {

    // menentukan child
    $data['have_child'] = $data['url'] == "#" ? 1 : 0;

    // menentukan level
    if($data['id_parent'] == 0) {
      $data['level'] = 1;
    } else {
      $get_level = Menu::where('id', $data['id_parent'])->first()->level;
      $data['level'] = $get_level + 1;
    }

    DB::transaction(function() use ($menu, $data) {
      $t = $menu;
      $t->nama = $data['nama'];
      $t->id_parent = $data['id_parent'];
      $t->have_child = $data['have_child'];
      $t->level = $data['level'];
      $t->url = $data['url'];
      $t->slug = $data['slug'];
      $t->save();

      DB::commit();
    });

    return $menu;
  }

  public static function delete($id) {
    $t = Menu::findOrFail($id)->delete();
  }

}
