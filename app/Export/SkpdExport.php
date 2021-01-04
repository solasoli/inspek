<?php
namespace App\Export;

use App\Repository\Master\Skpd;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SkpdExport implements FromView,ShouldAutoSize
{
    public function view(): View
    {
        return view('Mst.skpd-excel', [
            'skpd' => Skpd::where('is_deleted', 0)->orderBy('name')->get(),
        ]);
    }
}