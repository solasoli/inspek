<?php

/* Program kerja audit */

use App\Repository\Master\KodeRekomendasi;
use App\Repository\Master\KodeTemuan;

if (!function_exists('sp_tim')) {
    function sp_tim($list_inspektur, $idx = null, $data = null, $anggota = [], $opd = [])
    {   

        return view(
            'pkpt.partial.surat_perintah-tim', [
                'list_inspektur' => $list_inspektur,
                'idx' => $idx,
                'data' => $data,
                'anggota' => $anggota,
                'opd' => $opd
            ]
        );
    }
}
