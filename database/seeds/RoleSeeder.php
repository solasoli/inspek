<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('acl_role')->insert([
        [
          'id' => 1,
          'nama' => "Super Administrator",
        ]
      ]);
      DB::table('acl_role')->insert([
        [
          'id' => 2,
          'nama' => "Administrator",
        ]
      ]);
      DB::table('acl_role')->insert([
        [
          'id' => 3,
          'nama' => "Pegawai",
        ]
      ]);
    }
}
