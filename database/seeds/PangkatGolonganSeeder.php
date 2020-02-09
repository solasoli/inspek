<?php

use Illuminate\Database\Seeder;

class PangkatGolonganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	DB::insert("INSERT INTO `pgw_pangkat_golongan` (`id`, `name`, `is_deleted`) VALUES (1, 'IV/d', 0);");
	DB::insert("INSERT INTO `pgw_pangkat_golongan` (`id`, `name`, `is_deleted`) VALUES (2, 'IV/c', 0);");
	DB::insert("INSERT INTO `pgw_pangkat_golongan` (`id`, `name`, `is_deleted`) VALUES (3, 'IV/b', 0);");
	DB::insert("INSERT INTO `pgw_pangkat_golongan` (`id`, `name`, `is_deleted`) VALUES (4, 'IV/a', 0);");
	DB::insert("INSERT INTO `pgw_pangkat_golongan` (`id`, `name`, `is_deleted`) VALUES (5, 'III/d', 0);");
	DB::insert("INSERT INTO `pgw_pangkat_golongan` (`id`, `name`, `is_deleted`) VALUES (6, 'III/c', 0);");
	DB::insert("INSERT INTO `pgw_pangkat_golongan` (`id`, `name`, `is_deleted`) VALUES (7, 'III/b', 0);");
	DB::insert("INSERT INTO `pgw_pangkat_golongan` (`id`, `name`, `is_deleted`) VALUES (8, 'III/a', 0);");
	DB::insert("INSERT INTO `pgw_pangkat_golongan` (`id`, `name`, `is_deleted`) VALUES (9, 'IV/e', 0);");
	DB::insert("INSERT INTO `pgw_pangkat_golongan` (`id`, `name`, `is_deleted`) VALUES (10, 'II/d', 0);");
	DB::insert("INSERT INTO `pgw_pangkat_golongan` (`id`, `name`, `is_deleted`) VALUES (11, 'II/c', 0);");
	DB::insert("INSERT INTO `pgw_pangkat_golongan` (`id`, `name`, `is_deleted`) VALUES (12, 'II/b', 0);");
	DB::insert("INSERT INTO `pgw_pangkat_golongan` (`id`, `name`, `is_deleted`) VALUES (13, 'II/a', 0);");
	DB::insert("INSERT INTO `pgw_pangkat_golongan` (`id`, `name`, `is_deleted`) VALUES (14, 'I/d', 0);");
	DB::insert("INSERT INTO `pgw_pangkat_golongan` (`id`, `name`, `is_deleted`) VALUES (15, 'I/c', 0);");
	DB::insert("INSERT INTO `pgw_pangkat_golongan` (`id`, `name`, `is_deleted`) VALUES (16, 'I/b', 0);");
	DB::insert("INSERT INTO `pgw_pangkat_golongan` (`id`, `name`, `is_deleted`) VALUES (17, 'I/a', 0);");

    }
}
