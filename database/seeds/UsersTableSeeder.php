<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin',
            'password' => Hash::make('GarminStock2021'),
            'role' => '1'
        ]);
        User::create([
            'name' => 'sales',
            'email' => 'sales',
            'password' => Hash::make('123'),
            'role' => '2'
        ]);


    }
}
