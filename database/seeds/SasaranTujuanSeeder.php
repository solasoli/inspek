<?php

use Illuminate\Database\Seeder;

class SasaranTujuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('mst_sasaran_tujuan')->insert([
        [
          'id' => 1,
          'nama' => "Daftar Pemeriksaan Tujuan Tertentu",
        ]
      ]);
      DB::table('mst_sasaran_tujuan')->insert([
        [
          'id' => 2,
          'nama' => "Ruang Lingkup",
        ]
      ]);
      DB::table('mst_sasaran_tujuan')->insert([
        [
          'id' => 3,
          'nama' => "Tujuan Audit",
        ]
      ]);
      DB::table('mst_sasaran_tujuan')->insert([
        [
          'id' => 4,
          'nama' => "Metodelogi Audit",
        ]
      ]);
      DB::table('mst_sasaran_tujuan')->insert([
        [
          'id' => 5,
          'nama' => "Tahapan Audit",
        ]
      ]);
    }
}
