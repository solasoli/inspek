<?php
namespace App\Export;

use App\Repository\Pegawai\Pegawai;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PegawaiExport implements FromView,ShouldAutoSize
{
    public function view(): View
    {
        return view('Mst.pegawai-excel', [
            'pegawai' => Pegawai::where('is_deleted', 0)->orderBy('nama_asli')->get(),
        ]);
    }
}