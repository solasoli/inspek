<?php

use Illuminate\Database\Seeder;

class EselonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::insert("INSERT INTO `pgw_eselon` (`id`, `name`, `is_deleted`, `level`) VALUES (1, 'IIA', 0, 2);");
		DB::insert("INSERT INTO `pgw_eselon` (`id`, `name`, `is_deleted`, `level`) VALUES (2, 'IIB', 0, 2);");
		DB::insert("INSERT INTO `pgw_eselon` (`id`, `name`, `is_deleted`, `level`) VALUES (3, 'IIIA', 0, 3);");
		DB::insert("INSERT INTO `pgw_eselon` (`id`, `name`, `is_deleted`, `level`) VALUES (4, 'IIIB', 0, 3);");
		DB::insert("INSERT INTO `pgw_eselon` (`id`, `name`, `is_deleted`, `level`) VALUES (5, 'IVA', 0, 4);");
		DB::insert("INSERT INTO `pgw_eselon` (`id`, `name`, `is_deleted`, `level`) VALUES (6, 'IVB', 0, 4);");
		DB::insert("INSERT INTO `pgw_eselon` (`id`, `name`, `is_deleted`, `level`) VALUES (7, 'Staff', 0, 5);");

    }
}
