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
        $this->call(CustomerSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(BankingSeeder::class);
        $this->call(UserTypeSeeder::class);
        $this->call(PermissionUpdateSeeder::class);
        $this->call(UserSeeder::class);
    }
}
