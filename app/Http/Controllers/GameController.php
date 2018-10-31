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

    

    public function runGame()  
    {                                   
            $xmlpath = "public/blockly_files/toolbox0x0.xml";
            $xmltest = file_get_contents($xmlpath);
            
            $json0x0 = File::get("public/blockly_files/start0x0.json");
       
            if(Auth::check())
            {
                
                $auth = Auth::user();
                $savedGame = SavedGame::where('username', '=', $auth->username)->latest()->first();

                if($savedGame==null)
                {
                  
                  //pokial ulozena hra este neexistuje, ako ulozena hra sa nacita startovaci stav v hre
                  SavedGame::create(array('username' => $auth->username,
                   'category' => 0,
                   'level' => 0,
                   'json' => $json0x0             
                   ));  


                }

            }
            else
            {   //pokial uzivatel nie je prihlaseny, ako ulozena hra sa nacita startovaci stav v hre

                $savedGame = new SavedGame(['username' => '', 'category' => 0, 'level' => 0, 'json'=>  $json0x0 ]);
            }
        
            
     
          
         return view("game", compact('xmltest', 'savedGame'));
        
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