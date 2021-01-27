<?php
namespace App\Export;

use App\Repository\SuratPerintah\SuratPerintah;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use DB;

class SuratPerintahNomorExport implements FromView,ShouldAutoSize
{
    public $is_avail_no;
    
    public function __construct($is_avail_no = null)
    {
        $this->is_avail_no = is_null($is_avail_no) ? 0 : $is_avail_no;
    }

    public function view(): View
    {
        $data = SuratPerintah::with(['wilayah', 'program_kerja', 'sasaran', 'kegiatan'])->where('is_approve', 1);
    
        if ($this->is_avail_no == 1) {
          $data = $data->whereRaw(DB::raw("TRIM(no_surat) != ''"));
        } else {
          $data = $data->whereRaw(DB::raw("TRIM(no_surat) = ''"));
        }
        $data = $data->get();
        return view('pkpt.penomeran_surat-excel', [
            'data' => $data,
            'is_avail_no' => $this->is_avail_no
        ]);
    }
}