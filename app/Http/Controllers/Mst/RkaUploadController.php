<?php

namespace App\Http\Controllers\Mst;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Datatables;
use Validator;
use Auth;
use Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Input;
use App\TempKodeRekening;
use App\TempKodeRekeningDetail;
use App\RkaExcelCollection;
use App\Config;
use App\ConfigDetail;
use App\KodeRekening;

date_default_timezone_set('Asia/Jakarta');

class RkaUploadController extends Controller
{
    public function add_temp()
    {
      return view('Mst.rka_add_temp-form');
    }

    public function store_temp(Request $request)
    {
      $validator = Validator::make($request->all(), [
        'file' => 'required|mimes:xls,xlsx',
      ],[
        'file.required' => 'File harus diisi!',
        'file.mimes' => 'File harus berformat xls, xlsx'
      ]);
      if ($validator->fails()) {

        return back()
              ->withErrors($validator)
              ->withInput();
      }
      else {
        try {
          $store = Excel::import(new RkaExcelCollection, request()->file('file'));
          
          $last_data = DB::table('rka_rka')->latest('id')->first();
          return redirect('/rka/detail/'.$last_data->id);
        }
        catch (\Exception $e) {

          dd($e);
          \Session::flash('error', $e->getMessage());
            return redirect('/upload_kode_rekening');
        }
      }
    }

    public function verify_temp_form($id)
    {
      $tempkr = TempKodeRekening::findOrFail($id);
      $tempkrd = TempKodeRekeningDetail::where("id_kode_rekening", $id)->orderBy('row', 'ASC')->get();
      $config = getConfig("config_rekening_code_excel");

      return view('Mst.rekening_verify_temp-form', [
        'range_column' => range($tempkr->start_column, $tempkr->end_column),
        'data_temp' => $tempkrd,
        'config' => $config

      ]);
    }

    public function verify_temp(Request $request, $id)
    {
      $config = getConfig("config_rekening_code_excel");
      $tempkr = TempKodeRekening::findOrFail($id);
      $tempkrd = TempKodeRekeningDetail::where("id_kode_rekening", $id)->orderBy('row', 'ASC')->get();

      $data_insert = [];
      // loop si temporary table
      foreach($tempkrd as $idx => $row){
        // data asli kode rekening
        $new_data = [];

        //$kode_rekening->kode_rekening = $request->input('kode_rekening'); / value
        //$kode_rekening->uraian = $request->input('uraian'); / value

        foreach($config['config_detail'] as $i => $r){
          // si ieu teh ngecek aya teu inputan anu diambil dari config detail
          if(!is_null($request->input($r->column_in_db))){
            // ini isi nya alphabet yang dipilih kode_rekening / uraian
            $selected_alphabet = $request->input($r->column_in_db); // A

            $data = json_decode($row->value);//{"A":"Kode Rekening","B":"Uraian"} => ["A" => 'Kode Rekening', 'B' => 'Uraian']
            //$kode_rekening->kode_rekening = isset($data['A']) ? $data['A'] : '';
            $new_data[$r->column_in_db] = isset($data->{$selected_alphabet}) ? $data->{$selected_alphabet} : '';
          }
        }

        $new_data['created_by'] = Auth::user()->id;
        $new_data['created_at'] = date("Y-m-d H:i:s");
        $data_insert[] = $new_data;
      }

      //KodeRekening::insert($data_insert);
      $this->generate_parent();
      //dd($data_insert);
      //dd($request->input());
      $request->session()->flash('success', "Data berhasil disimpan.");
      return redirect("/upload_kode_rekening");
    }

    public function generate_parent(){
      // parent id generate di sini

      // kode rekening
      $kode_rekening = KodeRekening::where("is_deleted", 0)->get(); // collection semua data di databse

      // supaya tidak semua data di update, hanya yang perlu saja yang di update
      $data_to_update = [];
      //looping
      foreach($kode_rekening as $idx => $row){
        // array data yang perlu di update
        $new_data_update = [];

        // mencari parent dari kode rekening yang sedang di loop , contoh 41 | saya mencari parent si 41 dari seluruh data di database
        $find_parent = $this->find_parent($kode_rekening, $row->kode_rekening);

        if($find_parent != null){
          $new_data_update = [
            "parent_id" => $find_parent->id,
            'id' => $row->id
          ];

          $data_to_update[] = $new_data_update;
        }
      }

      //generate query update case
      $update_string = "UPDATE mst_kode_rekening
          SET parent_id =  CASE";

      $id_where = [];
      foreach($data_to_update as $idx => $row){
        $update_string .= " WHEN id = ". $row["id"] ." THEN ".$row["parent_id"]." ";
        $id_where[] = $row["id"];
      }
      $update_string .="
          END
          WHERE   id IN (".implode($id_where, ",").")";
      DB::update($update_string);

      // set tidak punya parent maka saya set level 1
      DB::update("UPDATE mst_kode_rekening SET level = 1 WHERE parent_id = 0 ");
      //indikator lamun misalna si data masih punya child , contoh , saya di level 1 , check level 2 aya teu
      $have_child = true;
      //set default level 1
      $level = 1; // <-- 2
      // while
      while($have_child){
        //ieu pengecekan level selanjutnya
        $get_child = collect(DB::select(DB::raw("SELECT COUNT(*) count FROM mst_kode_rekening WHERE parent_id IN (SELECT id FROM mst_kode_rekening WHERE level = {$level})")))->first();

        if($get_child->count > 0){
          $next_level = $level+1;
          DB::update("UPDATE mst_kode_rekening SET level = {$next_level} WHERE parent_id in (SELECT id FROM mst_kode_rekening WHERE level = {$level})");
          $level++;
        } else {
          $have_child = false;
        }
      }

      // update anu parent_id na 0 == 1
      // select * from mst_kode_rekening where parent_id = (id = level 1) update jadi level 2
      // select * from mst_kode_rekening where parent_id = (id = level 2) update jadi level 3

      //query == null
    }

    public function find_parent($list_array, $find){
      global $indikator;
      //$find = 41 , mun saya cari diantara $list_array , pasti benang na anu manehna sorangan
      // matak didieu ku saya di substr ,
      $indikator = substr($find, 0, strlen($find)-1); // 41 -> 401 , 40

      // set first parent to null or itself
      $parent = $list_array->where('kode_rekening', $indikator)->first();
      //
      while($list_array->where('kode_rekening', $indikator)->count() == 0 && $indikator != ''){
        //jadi 40 hela
        $parent = $list_array->where('kode_rekening', $indikator)->first();

        if($parent == null){
            //40
            $indikator = substr($indikator, 0, strlen($indikator)-1); // 4101 -> 4
        } else {
          break;
        }
      }

      return $parent;
    }

}
