<?php

namespace App\Service\Master;

use DB;
use Auth;
use Illuminate\Validation\Rule;
use App\Repository\Master\Skpd;
use App\Sasaran;

class SkpdService
{
    public static function create($data)
    {
        $t = new Skpd;
        return self::proccess_data($t, $data);
    }

    public static function update($id, $data)
    {
        $t = Skpd::findOrFail($id);
        return self::proccess_data($t, $data);
    }

    public static function createOrUpdate($id, $data)
    {
        $t = Skpd::findOrNew($id);
        return self::proccess_data($t, $data);
    }

    private static function proccess_data(Skpd $skpd, $data)
    {
        DB::transaction(function () use ($skpd, $data) {
            $t = $skpd;
            $t->name = $data['name'];
            $t->id_wilayah = $data['wilayah'];
            $t->pimpinan = $data['pimpinan'];
            $t->save();

            DB::commit();
        });

        return $skpd;
    }

    public static function delete($id)
    {
        $t = Skpd::findOrFail($id)->delete();
    }

    public static function get_data($is_deleted = 0)
    {
        return Skpd::where("is_deleted", $is_deleted)->get();
    }
}
