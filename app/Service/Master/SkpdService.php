<?php

namespace App\Service\Master;

use DB;
use Auth;
use Illuminate\Validation\Rule;
use App\Repository\Master\Skpd;
use App\Sasaran;

class SkpdService
{
    public static function get_validation($id = 0)
    {
        $rules = [
            'wilayah' => ['required']
        ];

        if ($id == 0) {
            $rules = array_merge(
                $rules,
                ['name' => [
                    'required',
                    Rule::unique('mst_skpd', 'name')->where(function ($query) {
                        return $query->where('is_deleted', 0);
                    })

                ]]
            );
        } else {
            $rules = array_merge(
                $rules,
                ['name' => [
                    'required',
                    Rule::unique('mst_skpd', 'name')->where(function ($query) use ($id) {
                        return $query->where('is_deleted', 0)->where("id", "!=", $id);
                    })

                ]]
            );
        }

        $label = [
            'name.required' => 'Nama SKPD harus diisi!',
            'name.unique' => 'Nama SKPD sudah ada!',
            'wilayah.required' => 'Wilayah harus diisi!'
        ];

        return (object) array(
            'rules' => $rules,
            'label' => $label
        );
    }

    public static function create($data)
    {
        $t = new Skpd;
        return self::proccess_data($t, $data);
    }

    public static function update($id_skpd, $data)
    {
        $t = Skpd::findOrFail($id_skpd);
        return self::proccess_data($t, $data);
    }

    public static function createOrUpdate($id_skpd, $data)
    {
        $t = Skpd::findOrNew($id_skpd);
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
}
