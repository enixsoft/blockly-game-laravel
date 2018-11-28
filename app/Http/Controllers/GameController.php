<?php
namespace App\Http\Controllers;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

use Auth;

use App\User;
use App\Models\SavedGame;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;

use Validator;

use Redirect;

use Log;

use DB;             

class GameController extends Controller
{    

    

    public function runGame($category, $level)  
    {                                   
            $xmlToolboxPath = "public/blockly_files/toolbox" . $category . "x" . $level . ".xml";
            $xmlToolbox = File::get($xmlToolboxPath);            
            
            $jsonStartGamePath = "public/blockly_files/start" . $category . "x" . $level . ".json";
            $jsonStartGame = File::get($jsonStartGamePath);
            
            $jsonTasksPath = "public/blockly_files/modals" . $category . "x" . $level . ".json";
            $jsonTasks = File::get($jsonTasksPath);

            //check progress first

            if(Auth::check())
            {
                
                $auth = Auth::user();
                $savedGame = SavedGame::where('username', '=', $auth->username)->where('category', '=', $category)->where('level', '=', $level)->latest()->first();

                if($savedGame==null)
                {
                  
                  //pokial ulozena hra este neexistuje, ako ulozena hra sa nacita startovaci stav v hre
                  
                  $savedGame = SavedGame::create(array('username' => $auth->username,
                   'category' => $category,
                   'level' => $level,
                   'json' => $jsonStartGame            
                   ));  

                 

                }

            }
            else
            {   //pokial uzivatel nie je prihlaseny, ako ulozena hra sa nacita startovaci stav v hre

                $savedGame = new SavedGame(['username' => '', 'category' => $category, 'level' => $level, 'json'=>  $jsonStartGame ]);
            }
        
            
     
          
         return view("game", compact('xmlToolbox', 'savedGame', 'jsonTasks'));
        
    }


      public function saveGame(Request $request)
    {      

        $data = $request->all(); 

         SavedGame::create(array('username' => $data['user'],
                   'category' => 0,
                   'level' => 0,
                   'json' => $data['save']          
                   ));  



        //Log::debug('Some message.');
        //Log::debug($data);
        
    }

    

}