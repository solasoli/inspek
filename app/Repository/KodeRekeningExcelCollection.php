<?php
namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\TempKodeRekening;
use App\TempKodeRekeningDetail;

class KodeRekeningExcelCollection implements ToCollection
{
    public function collection(Collection $rows)
    {
      $first_row = $rows->first()->filter(function($value, $key){
        return $value != null;
      });
      
      $data = ([
        'rows' => $rows,
        'start_column' => getNameFromNumber(0),
        'end_column' => getNameFromNumber($first_row->count()-1)
      ]);

      DB::beginTransaction();
      try {
        $t = new TempKodeRekening;
        $t->start_column = $data['start_column'];
        $t->end_column = $data['end_column'];
        $t->save();

        $x = 0;

        foreach($data['rows'] as $idx => $row){
          $x++;
          $new_row = [];

          foreach($row as $i => $r){
            if (!is_null($r)) {
              $new_row[getNameFromNumber($i)] = $r;
            }
          }

          $t2 = new TempKodeRekeningDetail;
          $t2->row = $x;
          $t2->value = json_encode($new_row);
          $t2->id_kode_rekening = $t->id;
          $t2->save();
          // echo "<pre>";
          // print_r(json_encode($new_row));
        }
        DB::commit();
      } catch(Exception $e) {
        DB::rollBack();
      }

    }
}
