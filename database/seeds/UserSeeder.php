<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new \App\Models\User();
        $user->name = 'admin';
        $user->email = 'admin@gmail.com';
        $user->password = \Illuminate\Support\Facades\Hash::make('12345678');
        $user->created_at = now();
        $user->updated_at = now();
        $user->save();
    }
}
