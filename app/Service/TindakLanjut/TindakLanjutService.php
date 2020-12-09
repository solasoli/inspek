<?php

namespace App\Service\TindakLanjut;

use DB;
use Auth;
use App\Repository\Pemeriksaan\AuditBerkas;
use App\Repository\Pemeriksaan\KertasKerja;
use App\Repository\Pemeriksaan\KertasKerjaIkhtisar;
use App\Repository\Pemeriksaan\KertasKerjaIkhtisarReview;
use App\Repository\Pemeriksaan\KertasKerjaIkhtisarTindakLanjut;
use App\Repository\Pemeriksaan\KertasKerjaReview;
use App\Repository\Pemeriksaan\KertasKerjaStatus;
use App\Repository\SuratPerintah\SuratPerintah;
use App\Repository\SuratPerintah\SuratPerintahStatus;
use App\Repository\SuratPerintah\SuratPerintahTindakLanjutReview;

class TindakLanjutService
{

    public static function createOrUpdate($id, $data) // $id = id_surat_perintah
    {
        DB::transaction(function () use ($id, $data) {
            self::proccess_data($id, $data);
            DB::commit();
        });
    }

    private static function proccess_data($id_surat_perintah, $data)
    {
        DB::transaction(function () use ($id_surat_perintah, $data) {
            $surat_perintah = SuratPerintah::findOrFail($id_surat_perintah);

            // find kertas kerja ikhtisar
            foreach($surat_perintah->audit_kertas_kerja as $row) {
                foreach($row->kertas_kerja_ikhtisar->where('is_compilation', 1) as $rw) {
                    // save tindak lanjut
                    $findTindakLanjut = KertasKerjaIkhtisarTindakLanjut::where('id_kertas_kerja_ikhtisar', $rw->id)
                    ->where('is_deleted',0)->first();

                    if($findTindakLanjut == null) {
                        $new_tindak_lanjut = new KertasKerjaIkhtisarTindakLanjut;
                        $new_tindak_lanjut->id_kertas_kerja_ikhtisar = $rw->id;
                        $new_tindak_lanjut->tindak_lanjut = !is_null($data['tindak_lanjut_'. $rw->id]) ? $data['tindak_lanjut_'. $rw->id] : '';
                        $new_tindak_lanjut->s = isset($data['s_'.$rw->id]) ? 1 : 0;
                        $new_tindak_lanjut->d = isset($data['d_'.$rw->id]) ? 1 : 0;
                        $new_tindak_lanjut->b = isset($data['b_'.$rw->id]) ? 1 : 0;
                        $new_tindak_lanjut->save();
                    } else {
                        $findTindakLanjut->tindak_lanjut = !is_null($data['tindak_lanjut_'. $rw->id]) ? $data['tindak_lanjut_'. $rw->id] : '';
                        $findTindakLanjut->s = isset($data['s_'.$rw->id]) ? 1 : 0;
                        $findTindakLanjut->d = isset($data['d_'.$rw->id]) ? 1 : 0;
                        $findTindakLanjut->b = isset($data['b_'.$rw->id]) ? 1 : 0;
                        $findTindakLanjut->save();
                    }
                }
            }
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
    public static function review($id, $data) // $id = id_surat_perintah
    {
        DB::transaction(function () use ($id, $data) {


            self::proccess_review($id, $data);
            DB::commit();
        });
    }

    public static function proccess_review($id, $data) // $id = id_surat_perintah
    {
        DB::transaction(function () use ($id, $data) {
            
            $findTindakLanjut = SuratPerintahTindakLanjutReview::where('id_surat_perintah', $id)
            ->where('is_deleted',0)->first();

            if($findTindakLanjut == null) {
                $newReview = new SuratPerintahTindakLanjutReview();
                $newReview->review = !is_null($data['review_tindak_lanjut']) ? $data['review_tindak_lanjut'] : '';
                $newReview->id_surat_perintah = $id;
                $newReview->save();
            } else {
                $findTindakLanjut->review = !is_null($data['review_tindak_lanjut']) ? $data['review_tindak_lanjut'] : '';
                $findTindakLanjut->save();
            }
            //self::proccess_review($id, $data, $tipe_review);
            DB::commit();
        });
    }

    public static function approve($id) // $id = id_surat_perintah
    {
        DB::transaction(function () use ($id) {
            $findSuratPerintah = SuratPerintah::findOrFail($id);
            $findSuratPerintah->is_approved_tindak_lanjut = 1;
            $findSuratPerintah->save();
            
            // remove review
            SuratPerintahTindakLanjutReview::where('id_surat_perintah', $id)
            ->where('is_deleted',0)->update(['is_deleted' => 1]);
            //self::proccess_review($id, $data, $tipe_review);
            DB::commit();
        });
    }
}
