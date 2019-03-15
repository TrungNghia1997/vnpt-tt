<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        User::updateOrCreate([
        	'name' => 'Superadmin',
        	'email' => 'superadmin@gmail.com',
        	'phone' => '09999999',
        	'password' => Hash::make('123456'),
        ]);

        User::updateOrCreate([
        	'name' => 'Admin',
        	'email' => 'admin@gmail.com',
        	'phone' => '08888888',
        	'password' => Hash::make('123456'),
        ]);
    }
}
