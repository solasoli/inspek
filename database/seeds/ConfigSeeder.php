<?php

use Illuminate\Database\Seeder;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      // dev_config
      DB::table('dev_config')->insert([
        [
          'id' => 1,
          'kode' => "config_rekening_code_excel",
          'nama' => "Kode Rekening Excel Config",
        ]
      ]);

      // dev_config_detail
      DB::table('dev_config_detail')->insert([
        [
          'id' => 1,
          'label' => "Kode Rekening",
          'column_in_db' => "kode_rekening",
          'id_config' => 1,
        ]
      ]);
      DB::table('dev_config_detail')->insert([
        [
          'id' => 2,
          'label' => "Uraian",
          'column_in_db' => "uraian",
          'id_config' => 1,
        ]
      ]);
    }
}
