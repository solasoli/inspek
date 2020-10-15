<?php

namespace App\Service\Master;

use DB;
use Auth;
use App\Kegiatan;
use App\Sasaran;
use App\Repository\Master\Wilayah;

class WilayahService
{

    public static function create($data)
    {
        $t = new Kegiatan;
        return self::proccess_data($t, $data);
    }

    public static function update($id_kegiatan, $data)
    {
        $t = Kegiatan::findOrFail($id_kegiatan);
        return self::proccess_data($t, $data);
    }

    public static function createOrUpdate($id_kegiatan, $data)
    {
        $t = Kegiatan::findOrNew($id_kegiatan);
        return self::proccess_data($t, $data);
    }

    private static function proccess_data(Kegiatan $kegiatan, $data)
    {

        DB::transaction(function () use ($kegiatan, $data) {
            $dari = explode('-', $data['dari']);
            $dari = $dari[2] . '-' . $dari[1] . '-' . $dari[0];
            $sampai = explode('-', $data['sampai']);
            $sampai = $sampai[2] . '-' . $sampai[1] . '-' . $sampai[0];

            $use = [
                'dari' => $dari,
                'sampai' => $sampai
            ];

            $t = $kegiatan;
            $t->nama = $data['nama'];
            $t->id_skpd = $data['opd'];
            $t->save();

            DB::commit();
        });

        return [
            'kegiatan' => $kegiatan,
            'sasaran' => Sasaran::where("is_deleted", 0)->where("id_kegiatan", $kegiatan->id)->get()
        ];
    }

    public static function delete($id)
    {
        $t = Wilayah::findOrFail($id)->delete();
    }

    public static function get_data($is_deleted = 0)
    {
        return Wilayah::where("is_deleted", $is_deleted)->get();
    }
}
