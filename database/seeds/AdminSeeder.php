<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'username' => "admin",
            'email' => "admin@blocklyhra.sk",
            'role' => "admin",
            'password' => Hash::make('password'),
        ]);     
    }
}
