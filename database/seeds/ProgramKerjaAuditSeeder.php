<?php

use Illuminate\Database\Seeder;

class ProgramKerjaAuditSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mst_program_kerja_audit')->insert([
          [
            'id' => 1,
            'nama' => "Judul",
          ]
        ]);
        DB::table('mst_program_kerja_audit')->insert([
          [
            'id' => 2,
            'nama' => "Pendahuluan",
          ]
        ]);
        DB::table('mst_program_kerja_audit')->insert([
          [
            'id' => 3,
            'nama' => "Tujuan Pemeriksaan",
          ]
        ]);
        DB::table('mst_program_kerja_audit')->insert([
          [
            'id' => 4,
            'nama' => "Ruang Lingkup Pemeriksaan",
          ]
        ]);
        DB::table('mst_program_kerja_audit')->insert([
          [
            'id' => 5,
            'nama' => "Waktu Pelaksanaan",
          ]
        ]);
    }
}
