<?php

namespace App\Service\Master;

use DB;
use Auth;
use Illuminate\Validation\Rule;
use App\Repository\Master\KodeTemuan;

class KodeTemuanService
{
    public static function get_validation($id = 0)
    {
    }

    public static function create($data)
    {
        $t = new KodeTemuan;
        return self::proccess_data($t, $data);
    }

    public static function update($id, $data)
    {
        $t = KodeTemuan::findOrFail($id);
        return self::proccess_data($t, $data);
    }

    public static function createOrUpdate($id, $data)
    {
        $t = KodeTemuan::findOrNew($id);
        return self::proccess_data($t, $data);
    }

    private static function proccess_data(KodeTemuan $eselon, $data)
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
        $t = KodeTemuan::findOrFail($id)->delete();
    }

    public static function get_data($is_deleted = 0)
    {
        return KodeTemuan::where("is_deleted", $is_deleted)->get();
    }

    public static function get_last_update() {
        $findLast = KodeTemuan::where('is_deleted', 0)
        ->orderBy('updated_at', 'DESC')
        ->limit(1)
        ->first();

        return ['last_update' => $findLast->updated_at];
    }
}
