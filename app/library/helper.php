<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Config;
use App\ConfigDetail;

if (!function_exists("guid_to_id")) {
  function guid_to_id ($guid, $table_name, $abort = true) {
    $id = DB::table($table_name)
    ->where('guid', $guid)
    ->where('is_deleted', 0)
    ->get()->first();
    $id = isset($id->id) ? $id->id : 0;

    if ($abort == true) {
      if ($id != 0) {
        return $id;
      }
      else {
        abort(404);
      }
    }
    else {
      return $id;
    }

  }
}

if (!function_exists("can_access")) {
  function can_access ($slug, $type = "view") {
      // $type = "add" / "view"/ "edit"/ "delete"
      $find_menu = Menu::where("slug", $slug)->first();
      if (isset($find_menu->id)) {
        // cek permission
        $check_permission = Permission::where("id_menu",$find_menu->id)
        ->where($type, 1)
        ->where("id_role", Auth::user()->id_role)
        ->first();
        if(isset($check_permission->id)){
          return true;
        } else {
          return false;
        }
      } else {
        return false;
      }
  }
}

if(!function_exists("terbilang_translate")){
  function terbilang_translate($nilai){
    if($nilai<0) {
      $hasil = "minus ". trim(penyebut($nilai));
    } else {
      $hasil = trim(penyebut($nilai));
    }
    return $hasil;
  }
}

if(!function_exists("penyebut")){
  function penyebut($nilai){
    $nilai = abs($nilai);
    $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    $temp = "";
    if ($nilai < 12) {
      $temp = " ". $huruf[$nilai];
    } else if ($nilai <20) {
      $temp = penyebut($nilai - 10). " belas";
    } else if ($nilai < 100) {
      $temp = penyebut($nilai/10)." puluh". penyebut($nilai % 10);
    } else if ($nilai < 200) {
      $temp = " seratus" . penyebut($nilai - 100);
    } else if ($nilai < 1000) {
      $temp = penyebut($nilai/100) . " ratus" . penyebut($nilai % 100);
    } else if ($nilai < 2000) {
      $temp = " seribu" . penyebut($nilai - 1000);
    } else if ($nilai < 1000000) {
      $temp = penyebut($nilai/1000) . " ribu" . penyebut($nilai % 1000);
    } else if ($nilai < 1000000000) {
      $temp = penyebut($nilai/1000000) . " juta" . penyebut($nilai % 1000000);
    } else if ($nilai < 1000000000000) {
      $temp = penyebut($nilai/1000000000) . " milyar" . penyebut(fmod($nilai,1000000000));
    } else if ($nilai < 1000000000000000) {
      $temp = penyebut($nilai/1000000000000) . " trilyun" . penyebut(fmod($nilai,1000000000000));
    }
    return ucwords($temp);
  }
}


if(!function_exists("bulan_indonesia")){
  function bulan_indonesia($no){
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


if(!function_exists("get_list_bulan_indonesia")){
  function get_list_bulan_indonesia(){
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

if(!function_exists('getNameFromNumber')){
  function getNameFromNumber($num) {
      $numeric = $num % 26;
      $letter = chr(65 + $numeric);
      $num2 = intval($num / 26);
      if ($num2 > 0) {
          return getNameFromNumber($num2 - 1) . $letter;
      } else {
          return $letter;
      }
  }

}


if(!function_exists('getConfig')){
  function getConfig($kode) {
    $config = Config::where("kode", $kode)->first();
    if($config == null)
      return null;

    $config_detail = ConfigDetail::where("id_config", $config->id)->get();
    return $config_return = [
      'config' => $config,
      'config_detail' => $config_detail
    ];
  }

}
