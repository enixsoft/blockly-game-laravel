<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $startNum = 16;
        $endNum = 25;    	

        for($i=$startNum;$i<=$endNum;$i++)        
        {
        User::create(array('username' => "hrac" . $i,
            'password' => bcrypt($i.'heslo'.$i),
            'email' => "hrac" . $i . "@blocklyhra.sk",
            'role' => "user",
            'remember_token' => null                

    	));  

        }

    }
}
