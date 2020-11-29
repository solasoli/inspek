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

if (!function_exists('pka_lkp_rinci_review')) {
    function pka_lkp_rinci_review($anggota, $idx = null, $data = null)
    {
        return view(
            'pemeriksaan.program-kerja-audit.partial-view.lkp_rinci-review',
            [
                'anggota' => $anggota,
                'idx' => $idx,
                'data' => $data
            ]
        );
    }
}

if (!function_exists('pka_lkp_rinci_detail')) {
    function pka_lkp_rinci_detail($anggota, $idx = null, $data = null)
    {
        return view(
            'pemeriksaan.program-kerja-audit.partial-view.lkp_rinci-detail',
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

if (!function_exists('pka_lkp_rinci_prosedur_review')) {
    function pka_lkp_rinci_prosedur_review($idxProsedur = null, $idx = null, $data = null)
    {
        return view(
            'pemeriksaan.program-kerja-audit.partial-view.lkp_rinci-prosedur-review',
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

if (!function_exists('pka_lkp_rinci_prosedur_detail_review')) {
    function pka_lkp_rinci_prosedur_detail_review($idx = null, $data = null, $idxProsedur = null, $idxLkp = null)
    {
        return view(
            'pemeriksaan.program-kerja-audit.partial-view.lkp_rinci-prosedur-detail-review',
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

if (!function_exists('pka_lkp_pelaksana_review')) {
    function pka_lkp_pelaksana_review($anggota, $idxLkp = null, $prosedur = null, $idxProsedur = null, $data = null)
    {
        return view(
            'pemeriksaan.program-kerja-audit.partial-view.lkp_rinci-pelaksana-review',
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

        $kodeRekomendasiLevel1 = KodeRekomendasi::where('level', 1)->get();
        $kodeRekomendasiLevel2 = KodeRekomendasi::where('level', 2)->get();
        return view(
            'pemeriksaan.audit.partial-view.kertas_kerja_ikhtisar',
            [
                'idx' => $idx,
                'data' => $data,
                'kode_temuan' => $kodeTemuanLevel1,
                'kode_rekomendasi_1' => $kodeRekomendasiLevel1,
                'kode_rekomendasi_2' => $kodeRekomendasiLevel2,
            ]
        );
    }
}

if (!function_exists('adt_kertas_kerja_ikhtisar_review')) {
    function adt_kertas_kerja_ikhtisar_review($idx = null, $data = null, $tipe_review = 'audit')
    {   
        return view(
            'pemeriksaan.audit.partial-view.kertas_kerja_ikhtisar-review',
            [
                'idx' => $idx,
                'data' => $data,
                'tipe_review' => $tipe_review
            ]
        );
    }
}

if (!function_exists('adt_kertas_kerja_ikhtisar_detail')) {
    function adt_kertas_kerja_ikhtisar_detail($idx = null, $data = null)
    {   
        return view(
            'pemeriksaan.audit.partial-view.kertas_kerja_ikhtisar-detail',
            [
                'idx' => $idx,
                'data' => $data
            ]
        );
    }
}


if (!function_exists('adt_kertas_kerja_ikhtisar_detail_modal')) {
    function adt_kertas_kerja_ikhtisar_detail_modal($data = null)
    {   
        return view(
            'pemeriksaan.audit.partial-view.kertas_kerja_ikhtisar-detail-modal',
            [
                'data' => $data
            ]
        );
    }
}

/* End Audit Section*/

/* Laporan NHP Section */

/* End Laporan NHP Section*/


if (!function_exists('kertas_kerja_status_label')) {

    function kertas_kerja_status_label($status) {
        $class = '';
        if(strpos($status->code, 'review') !== false) {
            $class = 'text-danger';
        } elseif(strpos($status->code, 'approved') !== false) {
            $class = 'text-success';
        }
        
        return "<b class='". $class ."'>". $status->description ."</b>";
    }
}


if (!function_exists('pemeriksaan_get_reviewer_tipe')) {

    function pemeriksaan_get_reviewer_tipe($tipe) {
        $reviewer = '';
        switch($tipe) {
            case "audit":
                $reviewer = 'Ketua Tim';
            break;
            case "nhp":
                $reviewer = 'Pengendali Teknis';
            break;
            case "lhp":
                $reviewer = 'Inspektur';
            break;
        }

        return $reviewer;
    }
}