<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(ConfigSeeder::class);
        $this->call(PegawaiSeeder::class);
        $this->call(SkpdSeeder::class);
        $this->call(EselonSeeder::class);
        $this->call(JabatanSeeder::class);
        $this->call(PangkatSeeder::class);
        $this->call(PangkatGolonganSeeder::class);
        $this->call(SasaranTujuanSeeder::class);
        $this->call(MenuSeeder::class);
    }
}
