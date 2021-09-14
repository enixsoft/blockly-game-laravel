<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $startNum = 51;
        $endNum = 60;    	

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
