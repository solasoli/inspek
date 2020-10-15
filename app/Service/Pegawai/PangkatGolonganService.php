<?php

namespace App\Service\Pegawai;

use DB;
use Auth;
use Illuminate\Validation\Rule;
use App\Repository\Pegawai\PangkatGolongan;

class PangkatGolonganService
{
    public static function get_validation($id = 0)
    {
    }

    public static function create($data)
    {
        $t = new PangkatGolongan;
        return self::proccess_data($t, $data);
    }

    public static function update($id, $data)
    {
        $t = PangkatGolongan::findOrFail($id);
        return self::proccess_data($t, $data);
    }

    public static function createOrUpdate($id, $data)
    {
        $t = PangkatGolongan::findOrNew($id);
        return self::proccess_data($t, $data);
    }

    private static function proccess_data(PangkatGolongan $eselon, $data)
    {
        DB::transaction(function () use ($eselon, $data) {
            $t = $eselon;
            $t->name = $data['name'];
            $t->level = $data['level'];
            $t->save();

            DB::commit();
        });

        return $eselon;
    }

    public static function delete($id)
    {
        $t = PangkatGolongan::findOrFail($id)->delete();
    }

    public static function get_data($is_deleted = 0)
    {
        return PangkatGolongan::where("is_deleted", $is_deleted)->get();
    }
}
