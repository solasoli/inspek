<?php

namespace App\Service\Pemeriksaan;

use DB;
use Auth;
use App\Repository\Pemeriksaan\AuditBerkas;
use App\Repository\Pemeriksaan\KertasKerja;
use App\Repository\Pemeriksaan\KertasKerjaIkhtisar;
use App\Repository\Pemeriksaan\KertasKerjaIkhtisarReview;
use App\Repository\Pemeriksaan\KertasKerjaReview;
use App\Repository\Pemeriksaan\KertasKerjaStatus;
use App\Repository\SuratPerintah\SuratPerintah;

class AuditService
{

    public static function createOrUpdate($id, $data) // $id = id_surat_perintah
    {
        DB::transaction(function () use ($id, $data) {
            self::proccess_data($id, $data);
            DB::commit();
        });
    }

    private static function proccess_data($id_kertas_kerja, $data)
    {
        DB::transaction(function () use ($id_kertas_kerja, $data) {
            // saving uraian singkat
            $kertas_kerja = KertasKerja::findOrFail($id_kertas_kerja);
            $kertas_kerja->uraian_singkat = $data['uraian_singkat'];
            $kertas_kerja->save();
            
            // inserting Langkah Kerja Pemeriksaan Rinci
            $mapping_kki = json_decode($data['mapping_kki']);
            $delete_data = [
                'is_deleted' => 1,
                'deleted_by' => Auth::user()->id,
                'deleted_at' => date("Y-m-d H:i:s"),
            ];

            $id_kki = [];
            foreach ($mapping_kki as $iKki => $rKki) {
                $data_ins_kki = [
                    'judul_kondisi' => $rKki->judul_kondisi->judul_kondisi,
                    'uraian_kondisi' => $rKki->uraian_kondisi->uraian_kondisi,
                    'kriteria' => $rKki->kriteria,
                    'sebab' => $rKki->sebab,
                    'akibat' => $rKki->akibat,
                    'rekomendasi' => $rKki->rekomendasi->rekomendasi,
                ];

                if (!self::checkValidateKki($data_ins_kki))
                    continue;

                if ($rKki->idKki == 0) {
                    $kki = $kertas_kerja->kertas_kerja_ikhtisar()->create($data_ins_kki);
                } else {
                    $kki = KertasKerjaIkhtisar::find($rKki->idKki);
                    $kki->id_status_kertas_kerja = 1;
                    $kki->update($data_ins_kki);
                }
                $id_kki[] = $kki->id;

                $kki->kode_temuan()->update($delete_data);
                $kki->kode_rekomendasi()->update($delete_data);

                // saving judul kondisi
                $list_judul_kondisi = [];
                for ($iSjt = 0; $iSjt < count($rKki->judul_kondisi->kode_temuan); $iSjt++) {
                    $kode_temuan = $rKki->judul_kondisi->kode_temuan[$iSjt];
                    if($kode_temuan->id_kode_temuan != '') {
                        $data_judul_kondisi = [
                            'id_kode_temuan' => $kode_temuan->id_kode_temuan /1,
                            'level' => $kode_temuan->level,
                            'tipe' => 'judul_kondisi'
                        ];

                        $list_judul_kondisi[] = $data_judul_kondisi;
                    }
                }
                $kki->kode_temuan()->createMany($list_judul_kondisi);

                // saving uraian kondisi
                $list_uraian_kondisi = [];
                for ($iSjt = 0; $iSjt < count($rKki->uraian_kondisi->kode_temuan); $iSjt++) {
                    $kode_temuan = $rKki->uraian_kondisi->kode_temuan[$iSjt];
                    
                    if($kode_temuan->id_kode_temuan != '') {
                        $data_uraian_kondisi = [
                            'id_kode_temuan' => $kode_temuan->id_kode_temuan /1,
                            'level' => $kode_temuan->level,
                            'tipe' => 'uraian_kondisi'
                        ];

                        $list_uraian_kondisi[] = $data_uraian_kondisi;
                    }
                }
                $kki->kode_temuan()->createMany($list_uraian_kondisi);

                // saving rekomendasi
                $list_rekomendasi = [];
                for ($iSjt = 0; $iSjt < count($rKki->rekomendasi->kode_rekomendasi); $iSjt++) {
                    $kode_rekomendasi = $rKki->rekomendasi->kode_rekomendasi[$iSjt];
                    $data_rekomendasi = [
                        'id_kode_rekomendasi' => isset($kode_rekomendasi->id_kode_rekomendasi) ? $kode_rekomendasi->id_kode_rekomendasi : 0,
                        'level' => $kode_rekomendasi->level,
                    ];

                    $list_rekomendasi[] = $data_rekomendasi;
                }
                $kki->kode_rekomendasi()->createMany($list_rekomendasi);
            }
            KertasKerjaIkhtisar::where('id_kertas_kerja', $id_kertas_kerja)->whereNotIn('id', $id_kki)->update($delete_data);
            DB::commit();
        });
    }

    private static function checkValidateKki($data = [])
    {
        $let_all_filled = false;
        foreach ($data as $idx => $row) {
            if (trim($row) != '') {
                $let_all_filled = true;
            }
        }

        return $let_all_filled;
    }

    public static function insert_berkas($id_kertas_kerja, $nama_berkas) {
        AuditBerkas::create(['id_kertas_kerja' => $id_kertas_kerja, 'file_url' => $nama_berkas]);
    }

    public static function review($id, $data, $tipe_review = 'audit') // $id = id_surat_perintah
    {
        DB::transaction(function () use ($id, $data, $tipe_review) {


            self::proccess_review($id, $data, $tipe_review);
            DB::commit();
        });
    }

    private static function proccess_review($id_kertas_kerja, $data, $tipe_review)
    {
        DB::transaction(function () use ($id_kertas_kerja, $data, $tipe_review) {

            // find Kertas Kerja
            $status = self::get_status_by_code('review_'. $tipe_review);
            $kertas_kerja = KertasKerja::findOrFail($id_kertas_kerja);
            $kertas_kerja->id_status_kertas_kerja = $status->id;
            $kertas_kerja->save();

            // find review
            $review = $kertas_kerja->review()->where('tipe',$tipe_review)->first();
            if(is_null($review)) {
                KertasKerjaReview::create([
                    'id_kertas_kerja' => $id_kertas_kerja,
                    'tipe' => $tipe_review,
                    'uraian_singkat' => $data['uraian_singkat']
                ]);
            } else {
                $review->uraian_singkat = $data['uraian_singkat'];
                $review->save();
            }

            // inserting Langkah Kerja Pemeriksaan Rinci
            $mapping_kki = json_decode($data['mapping_kki']);
            $delete_data = [
                'is_deleted' => 1,
                'deleted_by' => Auth::user()->id,
                'deleted_at' => date("Y-m-d H:i:s"),
            ];

            foreach ($mapping_kki as $iKki => $rKki) {

                $data_ins_kki = [
                    'judul_kondisi' => $rKki->judul_kondisi,
                    'uraian_kondisi' => $rKki->uraian_kondisi,
                    'kriteria' => $rKki->kriteria,
                    'sebab' => $rKki->sebab,
                    'akibat' => $rKki->akibat,
                    'rekomendasi' => $rKki->rekomendasi,
                    'tipe' => $tipe_review
                ];

                $kki = KertasKerjaIkhtisarReview::where('id_kertas_kerja_ikhtisar', $rKki->idKki)->where('tipe', $tipe_review)->first();
                if(is_null($kki)){
                    $data_ins_kki['id_kertas_kerja_ikhtisar'] = $rKki->idKki;
                    $kki = KertasKerjaIkhtisarReview::create($data_ins_kki);
                } else {
                    $kki->update($data_ins_kki);
                }
            }
            DB::commit();

        });
    }

    public static function approve($id_kertas_kerja, $tipe_review = 'audit') {
        $status = self::get_status_by_code('approved_'. $tipe_review);
        $kertas_kerja = KertasKerja::findOrFail($id_kertas_kerja);
        $kertas_kerja->id_status_kertas_kerja = $status->id;
        $kertas_kerja->save();
    }

    public static function get_status_by_code($code) {
        $status = KertasKerjaStatus::where('code', $code)->first();

        return $status;
    }
}
