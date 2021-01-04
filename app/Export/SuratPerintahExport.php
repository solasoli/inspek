<?php
namespace App\Export;

use App\Repository\Master\ProgramKerja;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SuratPerintahExport implements FromView,ShouldAutoSize
{
    public $tahun;
    
    public function __construct($tahun = null)
    {
        $this->tahun = is_null($tahun) ? date("Y") : $tahun;
    }

    public function view(): View
    {
        return view('Mst.program_kerja-excel', [
            'program_kerja' => ProgramKerja::where('is_deleted', 0)->orderBy('dari')
            ->whereRaw("YEAR(dari) = {$this->tahun}")
            ->get(),
        ]);
    }
}