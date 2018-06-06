<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
    	User::create(array('username' => "admin",
            'password' => bcrypt('admin123'),
            'email' => "admin@blocklyhra.sk",
            'role' => "admin",
            'remember_token' => null                

    	));   

    }
}
