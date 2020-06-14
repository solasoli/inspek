<?php
namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use App\TempKodeRekening;
use App\TempKodeRekeningDetail;
use App\UrusanPemerintahan;
use App\Organisasi;
use App\RKAProgram;
use App\RKAKegiatan;

class RkaExcelCollection implements ToCollection,WithCalculatedFormulas
{
    public function get_multiple_column($arr, $start, $end){
      $data = [];
      for($i = $start; $i<= $end; $i++){
        $data[] = $arr[$i];
      }
      return $data;
    }

    public function get_full_string($rows) {
      $data = [];
      foreach($rows as $idx => $row){
        if($row != null)
          $data[] = $row;
      }

      $string = implode(",", $data);
      return $string;
    }

    public function check_body_loop($row){
      $string = $this->get_full_string($row);
      $string = strtolower($string);
      return  strpos($string,'indikator') !== false && strpos($string, 'tolok ukur') !== false;
    }

    public function check_rincian_anggaran_loop($row) {
      $string = $this->get_full_string($row);
      $string = strtolower($string);
      return  strpos($string,'rincian') !== false && strpos($string, 'anggaran') !== false;

    }

    public function collection(Collection $rows)
    {
      $data = [];
      $data['rincian_anggaran'] = [];
      $data['indikator_kinerja'] = [];
      $last_indikator = '';
      $header_already_loop = false;
      $loop_already_on_body = false;
      $loop_rincian_anggaran = false;
      $loop_rincian_anggaran_uraian = false;
      $last_kode = "";
      $n = -1;
      foreach($rows as $idx => $row){

        //ini bagian header
        if(!$header_already_loop){
          switch (strtolower($row[1])) {
            case 'urusan pemerintahan':
            case 'organisasi':
            case 'program':
            case 'kegiatan':
              $label_row = strtolower(str_replace(" ", "_", $row[1]));
              $data_rows = $this->get_multiple_column($row, 15, 21);
              $data[$label_row] = $data_rows;
              $data[$label_row]['additional'] = $row[22];
              break;
            case 'lokasi kegiatan':
            case 'waktu pelaksanaan':
            case 'sumber dana':
              $label_row = strtolower(str_replace(" ", "_", $row[1]));
              $data[$label_row] = $row[15];
              break;
            case 'jumlah tahun':
              $label_n = 'n_-_1';
              if($n == 0) {
                $label_n = 'n';
              } else if($n == 1) {
                $label_n = 'n_+_1';
              } else {
                $data['n_min_year'] = $row[9];
              }
              $data[$label_n] = $row[20];
              $n++;
              break;
          }
        }

        //ini bagian body
        if($loop_already_on_body){
          if(!$header_already_loop)
            $header_already_loop = true;

          $current_indikator = strtolower(str_replace(" ", "_" , trim($row[1])));
          //if tolak ukur kinerja and target kinerja is not available anymore
          if($row[18] != ''){
            if($last_indikator != $current_indikator && $current_indikator != ''){
              $last_indikator = $current_indikator;
            }

            if(!isset($data['indikator_kinerja'][$last_indikator])){
              $data['indikator_kinerja'][$last_indikator] = [];
            }

            $data['indikator_kinerja'][$last_indikator][] = [
              "tolak_ukur_kinerja" => $row[18],
              "target_kinerja" => $row[30]
            ];
          }
        }

        //check must on bottom before loop body 
        //check if loop already to body
        if(!$loop_already_on_body){
          $loop_already_on_body = $this->check_body_loop($row);
        }

        //Rincian anggaran
        if($this->check_rincian_anggaran_loop($row)){
          $loop_rincian_anggaran = true;
          $loop_already_on_body = false;
        }

        if($loop_rincian_anggaran && $loop_rincian_anggaran_uraian){

          if(strtolower($row[1]) == 'jumlah'){
            $loop_rincian_anggaran = false;
          } else {
            $string = $this->get_multiple_column($row, 10, 24);
            $string = trim(implode(" ", $string));
            $kode = $this->get_multiple_column($row, 1, 9);
            $kode = trim(implode("", $kode));
            $kode = str_replace('-', '', $kode); 
            $volume = $row[25];
            $satuan = $row[27];
            $harga = $row[29];
            $total_harga = $row[30];

            if(strtolower($kode) == 'simralbogor' && $total_harga == null) { 
              $loop_rincian_anggaran_uraian = false;
              continue;
            }

            if($string != ""){
              if($kode != ""){
                $last_kode = $kode;
              }

              $data['rincian_anggaran'][] = [
                'kode' => $kode,
                'uraian' => $string,
                'volume' => $volume,
                'satuan' => $satuan,
                'harga' => $harga,
                'total_harga' => $total_harga,
                'parent' => $kode != "" ? "" : $last_kode
              ];

            }
          }
        }

        if($loop_rincian_anggaran && !$loop_rincian_anggaran_uraian && $row[1] == "1"){
          $loop_rincian_anggaran_uraian = true;
        }

        //dd($rows);
      }

      DB::beginTransaction();
      try {

        $this->saveToDB($data);
        DB::commit();
        
      } catch(Exception $e) {
        DB::rollBack();
      }

    }

    public function saveToDB($data =[]){
      //save to urusan pemerintahan first
      $up = $this->saveUrusanPemerintah($data);
      $o = $this->saveOrganisasi($data, $up);
      $pr = $this->saveProgram($data, $o);
      $k = $this->saveKegiatan($data, $pr);

      if($up != null && $o != null && $pr != null) {
        $list_id = [
          'id_up' => $up->id,
          'id_o' => $o->id,
          'id_pr' => $pr->id,
          'id_k' => $k->id
        ];
        $this->saveRka($data, $list_id);
      }

      DB::commit();
    }

    public function saveUrusanPemerintah($arr_data = []){
      if(isset($arr_data['urusan_pemerintahan'])){
        $data = $arr_data['urusan_pemerintahan'];
        $label = $data['additional'];
        unset($data['additional']);

        $kode = implode("", $data);

        if($kode != ""){
          //find it first in db
          $t = UrusanPemerintahan::firstOrCreate(['kode' => $kode],
          ['label' => $label]);
          return $t;
        }
      }

      return;

    }

    public function saveOrganisasi($arr_data = [], $up){
      if(isset($arr_data['organisasi']) && $up != null){
        $data = $arr_data['organisasi'];
        $label = $data['additional'];
        unset($data['additional']);

        $kode = implode("", $data);

        if($kode != ""){
          //find it first in db
          $t = Organisasi::firstOrCreate(['kode' => $kode],
          ['label' => $label, 'id_urusan_pemerintahan' => $up->id]);
          return $t;
        }
      }

      return;

    }

    public function saveProgram($arr_data = [], $o){
      if(isset($arr_data['program']) && $o != null){
        $data = $arr_data['program'];
        $label = $data['additional'];
        unset($data['additional']);

        $kode = implode("", $data);

        if($kode != ""){
          //find it first in db
          $t = RKAProgram::firstOrCreate(['kode' => $kode],
          ['label' => $label, 'id_organisasi' => $o->id]);
          return $t;
        }
      }

      return;
    }

    public function saveKegiatan($arr_data = [], $pr){
      if(isset($arr_data['kegiatan']) && $pr != null){
        $data = $arr_data['kegiatan'];
        $label = $data['additional'];
        unset($data['additional']);

        $kode = implode("", $data);

        if($kode != ""){
          //find it first in db
          $t = RKAKegiatan::firstOrCreate(['kode' => $kode],
          ['label' => $label, 'id_program' => $pr->id]);
          return $t;
        }
      }

      return;
    }

    public function saveRka($arr_data = [], $list_id){
      if(isset($arr_data['indikator_kinerja'])){
        // Save to RKA first
        $rka = new RKA;
        $rka->id_urusan_pemerintahan = isset($list_id['id_up']) ? $list_id['id_up'] : 0;
        $rka->id_organisasi = isset($list_id['id_o']) ? $list_id['id_o'] : 0;
        $rka->id_program = isset($list_id['id_pr']) ? $list_id['id_pr'] : 0;
        $rka->id_kegiatan = isset($list_id['id_k']) ? $list_id['id_k'] : 0; 
        $rka->lokasi_kegiatan = isset($arr_data['lokasi_kegiatan']) ? $arr_data['lokasi_kegiatan'] : "";
        $rka->waktu_pelaksanaan = isset($arr_data['waktu_pelaksanaan']) ? $arr_data['waktu_pelaksanaan'] : "";
        $rka->sumber_dana = isset($arr_data['sumber_dana']) ? $arr_data['sumber_dana'] : "";
        $rka->n_min = isset($arr_data['n_-_1']) ? $this->return_int_from_idr($arr_data['n_-_1']) : "";
        $rka->n = isset($arr_data['n']) ? $this->return_int_from_idr($arr_data['n']) : "";
        $rka->n_max = isset($arr_data['n_+_1']) ? $this->return_int_from_idr($arr_data['n_+_1']) : "";
        $rka->n_min_year = isset($arr_data['n_min_year']) ? $arr_data['n_min_year'] : "";
        $rka->save();

        //save to RKA indikator kinerja
        foreach($arr_data["indikator_kinerja"] as $idx => $val){
          // dd($idx, $val);

          $rka_ik = new RKAIndikatorKinerja;
          $rka_ik->id_rka = $rka->id;
          $rka_ik->indikator = ucwords(str_replace("_" , " ", $idx));
          $rka_ik->save();

          //detail
          foreach($val as $i => $v){
            $rka_ikd = new RKAIndikatorKinerjaDetail;
            $rka_ikd->id_indikator_kinerja = $rka_ik->id;
            $rka_ikd->tolak_ukur_kinerja = $v['tolak_ukur_kinerja'];
            $rka_ikd->target_kinerja = $v['target_kinerja'];
            $rka_ikd->save();
          }
        }

        $rincian_anggaran = collect($arr_data["rincian_anggaran"]);
        foreach($rincian_anggaran->where("parent", "") as $idx => $val){
          // dd($idx, $val);

          //kode rekening
          $kode_rekening = KodeRekening::firstOrCreate(['kode_rekening' => $val["kode"]],
          ['uraian' => $val["uraian"]]);

          $rka_ik = new RKARincianAnggaran;
          $rka_ik->id_rka = $rka->id;
          $rka_ik->id_kode_rekening = $kode_rekening->id;
          $rka_ik->jumlah = $val["total_harga"] > 0 ? $val["total_harga"] : 0;
          $rka_ik->save();

          //detail
          foreach($rincian_anggaran->where("parent", $val["kode"]) as $i => $v){
            //satuan
            $satuan = null;
            if($v["satuan"] != null){
              $satuan = Satuan::firstOrCreate(['nama' => $v["satuan"]]);
            }

            $rka_ikd = new RKARincianAnggaranDetail;
            $rka_ikd->id_rincian_anggaran = $rka_ik->id;
            $rka_ikd->uraian = $v['uraian'];
            $rka_ikd->volume = $v['volume'] > 0 ? $v['volume'] : 0;
            $rka_ikd->id_satuan = $satuan != null ? $satuan->id : 0;
            $rka_ikd->harga = $v["harga"] > 0 ? $v['harga'] : 0;
            $rka_ikd->jumlah = $v["total_harga"] > 0 ? $v['total_harga'] : 0;
            $rka_ikd->save();
          }
        }
      }

      return;
    }

    public function return_int_from_idr($string){
      $return = str_replace("Rp", "", $string);
      $return = str_replace(".", "", $return);
      $return = str_replace(",",".", $return);
      $return = str_replace("-","",$return);
      return trim($return);

    }
}
