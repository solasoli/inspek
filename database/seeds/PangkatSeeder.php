<?php

use Illuminate\Database\Seeder;

class PangkatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	DB::insert("INSERT INTO `pgw_pangkat` (`id`, `name`, `is_deleted`) VALUES (1, 'Pembina Utama Madya', 0);");
	DB::insert("INSERT INTO `pgw_pangkat` (`id`, `name`, `is_deleted`) VALUES (2, 'Pembina Utama Muda', 0);");
	DB::insert("INSERT INTO `pgw_pangkat` (`id`, `name`, `is_deleted`) VALUES (3, 'Pembina Tingkat I', 0);");
	DB::insert("INSERT INTO `pgw_pangkat` (`id`, `name`, `is_deleted`) VALUES (4, 'Pembina', 0);");
	DB::insert("INSERT INTO `pgw_pangkat` (`id`, `name`, `is_deleted`) VALUES (5, 'Penata Tingkat I', 0);");
	DB::insert("INSERT INTO `pgw_pangkat` (`id`, `name`, `is_deleted`) VALUES (6, 'Penata', 0);");
	DB::insert("INSERT INTO `pgw_pangkat` (`id`, `name`, `is_deleted`) VALUES (7, 'Penata Muda Tingkat I', 0);");
	DB::insert("INSERT INTO `pgw_pangkat` (`id`, `name`, `is_deleted`) VALUES (8, 'Penata Muda', 0);");
	DB::insert("INSERT INTO `pgw_pangkat` (`id`, `name`, `is_deleted`) VALUES (9, 'Pembina Utama', 0);");
	DB::insert("INSERT INTO `pgw_pangkat` (`id`, `name`, `is_deleted`) VALUES (10, 'Pengatur Tingkat I', 0);");
	DB::insert("INSERT INTO `pgw_pangkat` (`id`, `name`, `is_deleted`) VALUES (11, 'Pengatur', 0);");
	DB::insert("INSERT INTO `pgw_pangkat` (`id`, `name`, `is_deleted`) VALUES (12, 'Pengatur Muda Tingkat I', 0);");
	DB::insert("INSERT INTO `pgw_pangkat` (`id`, `name`, `is_deleted`) VALUES (13, 'Pengatur Muda', 0);");
	DB::insert("INSERT INTO `pgw_pangkat` (`id`, `name`, `is_deleted`) VALUES (14, 'Juru Tingkat I', 0);");
	DB::insert("INSERT INTO `pgw_pangkat` (`id`, `name`, `is_deleted`) VALUES (15, 'Juru', 0);");
	DB::insert("INSERT INTO `pgw_pangkat` (`id`, `name`, `is_deleted`) VALUES (16, 'Juru Muda Tingkat I', 0);");
	DB::insert("INSERT INTO `pgw_pangkat` (`id`, `name`, `is_deleted`) VALUES (17, 'Juru Muda', 0);");

    }
}
