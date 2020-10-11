<?php

namespace App\Service\Pegawai;

use DB;
use Auth;
use Illuminate\Validation\Rule;
use App\Repository\Pegawai\Peran;

class PeranService
{
    public static function get_validation($id = 0)
    {
    }

    public static function create($data)
    {
        $t = new Peran;
        return self::proccess_data($t, $data);
    }

    public static function update($id, $data)
    {
        $t = Peran::findOrFail($id);
        return self::proccess_data($t, $data);
    }

    public static function createOrUpdate($id, $data)
    {
        $t = Peran::findOrNew($id);
        return self::proccess_data($t, $data);
    }

    private static function proccess_data(Peran $eselon, $data)
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
        $t = Peran::findOrFail($id)->delete();
    }

    public static function get_data($is_deleted = 0)
    {
        return Peran::where("is_deleted", $is_deleted)->get();
    }

    public static function get_specific_role_by_code($roles = []) {
        return Peran::whereIn('kode', $roles)->get();
    }
}
