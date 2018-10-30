<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\SavedGame;

class SavedgamesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("public/blockly_files/start0x0.json");


        SavedGame::create(array('username' => "admin",
            'category' => 0,
            'level' => 0,
            'json' => $json            
		));   
    }
}
