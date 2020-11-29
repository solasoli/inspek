<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Repository\ACL\Menu;
use App\Repository\ACL\Permission;
use App\Repository\Master\Skpd;

if (!function_exists("can_access")) {
  function can_access($slug, $type = "view")
  {
    // $type = "add" / "view"/ "edit"/ "delete"
    $find_menu = Menu::where("slug", $slug)->first();
    if (!is_null(Auth::user())) {
      if (Auth::user()->id_role == 1) {
        return true;
      } else if (isset($find_menu->id)) {
        // cek permission
        $check_permission = Permission::where("id_menu", $find_menu->id)
          ->where($type, 1)
          ->where("id_role", Auth::user()->id_role)
          ->first();
        if (isset($check_permission->id)) {
          return true;
        } else {
          return false;
        }
      } else {
        return false;
      }
    }
  }
}


if (!function_exists("can_access_from_url")) {
  function can_access_from_url($type = "view")
  {
    //get slug by url
    $slug = Request::segment(1) . "_" . Request::segment(2);
    // $type = "add" / "view"/ "edit"/ "delete"
    $find_menu = Menu::where("slug", $slug)->first();
    if (!is_null(Auth::user())) {
      if (Auth::user()->id_role == 1) {
        return true;
      } else if (isset($find_menu->id)) {
        // cek permission
        $check_permission = Permission::where("id_menu", $find_menu->id)
          ->where($type, 1)
          ->where("id_role", Auth::user()->id_role)
          ->first();
        if (isset($check_permission->id)) {
          return true;
        } else {
          return false;
        }
      } else {
        return false;
      }
    }
  }
}

if (!function_exists("can_access_child")) {
  function can_access_child($slug, $type = "view")
  {
    // $type = "add" / "view"/ "edit"/ "delete"
    $find_menu = Menu::where("slug", $slug)->first();
    $child = findChild($find_menu->id);

    if (!is_null(Auth::user())) {
      if (Auth::user()->id_role == 1) {
        return true;
      } else {
        // cek permission
        $check_permission = Permission::whereIn("id_menu", $child)
          ->where($type, 1)
          ->where("id_role", Auth::user()->id_role)
          ->first();
        if (isset($check_permission->id)) {
          return true;
        } else {
          return false;
        }
      }
    } else {
      return false;
    }
  }
}

if (!function_exists("is_anggota")) {
  function is_anggota()
  {
    $get_role = DB::table("users AS u")
      ->where("u.id", Auth::user()->id)
      ->join("acl_role AS r", "r.id", "=", "u.id_role")
      ->select("r.*")
      ->first();
    return $get_role->is_anggota == 1 ? true : false;
  }
}

if (!function_exists("terbilang_translate")) {
  function terbilang_translate($nilai)
  {
    if ($nilai < 0) {
      $hasil = "minus " . trim(penyebut($nilai));
    } else {
      $hasil = trim(penyebut($nilai));
    }
    return $hasil;
  }
}

if (!function_exists("penyebut")) {
  function penyebut($nilai)
  {
    $nilai = abs($nilai);
    $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    $temp = "";
    if ($nilai < 12) {
      $temp = " " . $huruf[$nilai];
    } else if ($nilai < 20) {
      $temp = penyebut($nilai - 10) . " belas";
    } else if ($nilai < 100) {
      $temp = penyebut($nilai / 10) . " puluh" . penyebut($nilai % 10);
    } else if ($nilai < 200) {
      $temp = " seratus" . penyebut($nilai - 100);
    } else if ($nilai < 1000) {
      $temp = penyebut($nilai / 100) . " ratus" . penyebut($nilai % 100);
    } else if ($nilai < 2000) {
      $temp = " seribu" . penyebut($nilai - 1000);
    } else if ($nilai < 1000000) {
      $temp = penyebut($nilai / 1000) . " ribu" . penyebut($nilai % 1000);
    } else if ($nilai < 1000000000) {
      $temp = penyebut($nilai / 1000000) . " juta" . penyebut($nilai % 1000000);
    } else if ($nilai < 1000000000000) {
      $temp = penyebut($nilai / 1000000000) . " milyar" . penyebut(fmod($nilai, 1000000000));
    } else if ($nilai < 1000000000000000) {
      $temp = penyebut($nilai / 1000000000000) . " trilyun" . penyebut(fmod($nilai, 1000000000000));
    }
    return ucwords($temp);
  }
}


if (!function_exists("bulan_indonesia")) {
  function bulan_indonesia($no)
  {
    $no = $no / 1;
    $bulan = [
      '',
      'Januari',
      'Februari',
      'Maret',
      'April',
      'Mei',
      'Juni',
      'Juli',
      'Agustus',
      'September',
      'Oktober',
      'November',
      'Desember'
    ];
    return $bulan[$no];
  }
}


if (!function_exists("get_list_bulan_indonesia")) {
  function get_list_bulan_indonesia()
  {
    $bulan = [
      'Januari',
      'Februari',
      'Maret',
      'April',
      'Mei',
      'Juni',
      'Juli',
      'Agustus',
      'September',
      'Oktober',
      'November',
      'Desember'
    ];
    return $bulan;
  }
}


if (!function_exists("get_skpd_by_login")) {
  function get_skpd_by_login()
  {
    if (Auth::user()->id_role == 1) {
      return Skpd::where("is_deleted", 0)->get();
    } else {

      return Skpd::where("is_deleted", 0)->where("id", Auth::user()->id_skpd)->get();
    }
  }
}

if (!function_exists("must_show_skpd_form")) {
  function must_show_skpd_form()
  {
    if (Auth::user()->id_role == 1) {
      return true;
    } else {
      return false;
    }
  }
}

if (!function_exists("getAllParentMenuUser")) {
  function getAllParentMenuUser()
  {

    $access_user = DB::table("acl_menu AS m")
      ->select("m.id")
      ->where('is_deleted', 0);
    if (Auth::user()->id_role != 1) {
      $access_user = $access_user->where("id_role", Auth::user()->id_role)
        ->where("view", 1)
        ->join("acl_permission AS p", "m.id", "=", "p.id_menu");
    }
    $access_user = $access_user->get();


    $data_parent = [];
    foreach ($access_user as $idx => $row) {
      $data_parent[] = findParent($row->id);
    }
    return $data_parent;
  }

  function findParent($menu_id)
  {
    $current = Menu::find($menu_id);
    $parent = Menu::find($current->id_parent);
    if ($parent == null && $current->level == 1) {
      return $current->id;
    } else {
      return findParent($parent->id);
    }
  }

  function findChild($menu_id)
  {
    $child = Menu::where("id_parent", $menu_id)
      ->select("id")
      ->get();

    if ($child != null) {
      $child_arr = [];
      foreach ($child as $idx => $row) {
        $child_arr[] = $row->id;
        if (findChild($row->id) != null) {
          $child_arr = array_merge($child_arr, findChild($row->id));
        }
      }
      return $child_arr;
    }
    return null;
  }
}



if (!function_exists("generateChildPermission")) {
  function generateChildPermission($menu_id, $data_array, $no_array = [])
  {

    $menu_child_html = "";
    $get_child = Menu::where("is_deleted", 0)->where("id_parent", $menu_id)->get();
    $parent_row = Menu::where("is_deleted", 0)->where("id", $menu_id)->first();

    $parent_nbsp = "";
    if (isset($parent_row->level)) {
      for ($ip = 2; $ip <= $parent_row->level; $ip++) {
        $parent_nbsp .= "&nbsp; &nbsp;";
      }
    }

    if ($get_child->count() > 0) {
      $parent_no = isset($no_array[$parent_row->level]) ? $no_array[$parent_row->level] + 1 : 1;
      $menu_child_html .= "<tr><td colspan=6>{$parent_nbsp}{$parent_row->nama}</td>";
      foreach ($get_child as $ix => $rw) {


        $view_checked = isset($data_array['view'][$rw->id]) && $data_array['view'][$rw->id] == 1 ? "checked" : "";
        $add_checked = isset($data_array['add'][$rw->id]) && $data_array['add'][$rw->id] == 1 ? "checked" : "";
        $edit_checked = isset($data_array['edit'][$rw->id]) && $data_array['edit'][$rw->id] == 1 ? "checked" : "";
        $delete_checked = isset($data_array['delete'][$rw->id]) && $data_array['delete'][$rw->id] == 1 ? "checked" : "";
        $additional_checked = isset($data_array['additional'][$rw->id]) && $data_array['additional'][$rw->id] == 1 ? "checked" : "";
        $check_all_checked = $view_checked == "checked" &&
          $add_checked == "checked" &&
          $edit_checked == "checked" &&
          $delete_checked == "checked" &&
          $additional_checked == "checked" ? "checked" : "";

        $check_html = "<td align='center'>
        <input type='hidden' name='menu[]' value={$rw->id}>
        <input name='view[{$rw->id}]' type='checkbox' value='1' {$view_checked}>
        </td>
        <td align='center'>
          <input name='add[{$rw->id}]' type='checkbox' value='1' {$add_checked}>
        </td>
        <td align='center'>
          <input name='edit[{$rw->id}]' type='checkbox' value='1' {$edit_checked}>
        </td>
        <td align='center'>
          <input name='delete[{$rw->id}]' type='checkbox' value='1' {$delete_checked}>
        </td>
        <td align='center'>
          <input name='additional[{$rw->id}]' type='checkbox' value='1' {$additional_checked}>
        </td>
        <td align='center'>
          <input class='check_all' type='checkbox' value='1' {$check_all_checked}>
        </td>";

        if ($rw->have_child == 1) {
          $menu_child_html .= generateChildPermission($rw->id, $data_array);
        } else {
          $menu_child_html .= "<tr clas><td>{$parent_nbsp}&nbsp; &nbsp; - {$rw->nama}</td> {$check_html}</tr>";
        }
      }
    } else {

      $view_checked = isset($data_array['view'][$parent_row->id]) && $data_array['view'][$parent_row->id] == 1 ? "checked" : "";
      $add_checked = isset($data_array['add'][$parent_row->id]) && $data_array['add'][$parent_row->id] == 1 ? "checked" : "";
      $edit_checked = isset($data_array['edit'][$parent_row->id]) && $data_array['edit'][$parent_row->id] == 1 ? "checked" : "";
      $delete_checked = isset($data_array['delete'][$parent_row->id]) && $data_array['delete'][$parent_row->id] == 1 ? "checked" : "";
      $additional_checked = isset($data_array['additional'][$parent_row->id]) && $data_array['additional'][$parent_row->id] == 1 ? "checked" : "";
      $check_all_checked = $view_checked == "checked" &&
        $add_checked == "checked" &&
        $edit_checked == "checked" &&
        $delete_checked == "checked" &&
        $additional_checked == "checked" ? "checked" : "";
      $menu_child_html .= "<tr><td>{$parent_nbsp}{$parent_row->nama}</td>
        <td align='center'>
          <input type='hidden' name='menu[]' value={$parent_row->id}>
          <input name='view[{$parent_row->id}]' type='checkbox' value='1' {$view_checked}>
        </td>
        <td align='center'>
          <input name='add[{$parent_row->id}]' type='checkbox' value='1' {$add_checked}>
        </td>
        <td align='center'>
          <input name='edit[{$parent_row->id}]' type='checkbox' value='1' {$edit_checked}>
        </td>
        <td align='center'>
          <input name='delete[{$parent_row->id}]' type='checkbox' value='1' {$delete_checked}>
        </td>
        <td align='center'>
          <input name='additional[{$parent_row->id}]' type='checkbox' value='1' {$additional_checked}>
        </td>
        <td align='center'>
          <input class='check_all' type='checkbox' value='1' {$check_all_checked}>
        </td>";
    }

    return $menu_child_html;
  }
}


if (!function_exists("get_constant")) {
  function get_constant($constant)
  {
    // loading constant variable
    include 'constant.php';
    return $$constant;
  }
}

if (!function_exists('num2alpha')) {
  function num2alpha($n)
  {
    for ($r = ""; $n >= 0; $n = intval($n / 26) - 1)
      $r = chr($n % 26 + 0x41) . $r;
    return $r;
  }
}
