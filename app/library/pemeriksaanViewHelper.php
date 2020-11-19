<?php

/* Program kerja audit */

use App\Repository\Master\KodeRekomendasi;
use App\Repository\Master\KodeTemuan;

if (!function_exists('pka_lkp_rinci')) {
    function pka_lkp_rinci($anggota, $idx = null, $data = null)
    {
        return view(
            'pemeriksaan.program-kerja-audit.partial-view.lkp_rinci',
            [
                'anggota' => $anggota,
                'idx' => $idx,
                'data' => $data
            ]
        );
    }
}

if (!function_exists('pka_sub_judul_tugas')) {
    function pka_sub_judul_tugas($data = '[value]')
    {
        return view(
            'pemeriksaan.program-kerja-audit.partial-view.sub_judul_tugas',
            [
                'sub_judul' => $data
            ]
        );
    }
}

if (!function_exists('pka_lkp_rinci_prosedur')) {
    function pka_lkp_rinci_prosedur($idxProsedur = null, $idx = null, $data = null)
    {
        return view(
            'pemeriksaan.program-kerja-audit.partial-view.lkp_rinci-prosedur',
            [
                'data' => $data,
                'idx' => $idx,
                'idxProsedur' => $idxProsedur,
            ]
        );
    }
}

if (!function_exists('pka_lkp_rinci_prosedur_detail')) {
    function pka_lkp_rinci_prosedur_detail($idx = null, $data = null, $idxProsedur = null, $idxLkp = null)
    {
        return view(
            'pemeriksaan.program-kerja-audit.partial-view.lkp_rinci-prosedur-detail',
            [
                'data' => $data,
                'idx' => $idx,
                'idxProsedur' => $idxProsedur,
                'idxLkp' => $idxLkp,
            ]
        );
    }
}



if (!function_exists('pka_lkp_pelaksana')) {
    function pka_lkp_pelaksana($anggota, $idxLkp = null, $prosedur = null, $idxProsedur = null, $data = null)
    {
        return view(
            'pemeriksaan.program-kerja-audit.partial-view.lkp_rinci-pelaksana',
            [
                'anggota' => $anggota,
                'idxLkp' => $idxLkp,
                'prosedur' => $prosedur,
                'idxProsedur' => $idxProsedur,
                'data' => $data,
            ]
        );
    }
}

/* End Program Kerja Audit */

/* Audit Section */

if (!function_exists('adt_kertas_kerja_ikhtisar')) {
    function adt_kertas_kerja_ikhtisar($idx = null, $data = null)
    {   
        $kodeTemuanLevel1 = KodeTemuan::where('level',1)->get();
        $kodeTemuanLevel2 = KodeTemuan::where('level',2)->get();
        $kodeTemuanLevel3 = KodeTemuan::where('level',3)->get();

        $kodeRekomendasiLevel1 = KodeRekomendasi::where('level', 1)->get();
        $kodeRekomendasiLevel2 = KodeRekomendasi::where('level', 2)->get();
        return view(
            'pemeriksaan.audit.partial-view.kertas_kerja_ikhtisar',
            [
                'idx' => $idx,
                'data' => $data,
                'kode_temuan' => $kodeTemuanLevel1,
                'kode_temuan_2' => $kodeTemuanLevel2,
                'kode_temuan_3' => $kodeTemuanLevel3,
                'kode_rekomendasi_1' => $kodeRekomendasiLevel1,
                'kode_rekomendasi_2' => $kodeRekomendasiLevel2,
            ]
        );
    }
}

/* End Audit Section*/