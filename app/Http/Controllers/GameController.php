<?php
namespace App\Http\Controllers;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

use Auth;

use App\User;
use App\Models\SavedGame;
use App\Models\IngameProgress;

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

            $jsonModalsPath = "public/blockly_files/modals.json";
            $jsonModals = File::get($jsonModalsPath);


         

            if(Auth::check())
            {
                
                $auth = Auth::user();

                $inGameProgress = IngameProgress::where('username', '=', $auth->username)->where('category', '=', $category)->where('level', '=', $level)->latest()->first();


                if($inGameProgress!=null)
                {
                    if($inGameProgress['progress']==100)
                    {
                        $savedGame = SavedGame::where('username', '=', $auth->username)->where('category', '=', $category)->where('level', '=', $level)->latest()->first();   
                    } 
                    else
                    {                    
                        $savedGame = SavedGame::where('username', '=', $auth->username)->where('category', '=', $category)->where('level', '=', $level)->where('progress', '=', $inGameProgress['progress'])->latest()->first();
                    }
                }
                           
                else
                {
                 
                 
                  //no ingame progress in this category and level exists yet for this user, create 0 progress
                  
                 IngameProgress::create(['username' => $auth->username, 'category' => $category,
                    'level' => $level,  
                    'progress' => 0   
                    ]);
                
                  
                  //no saved game in this category and level exists yet for this user, create first saved game with 0 progress from startgame json
                  
                  $savedGame = SavedGame::create(array('username' => $auth->username,
                   'category' => $category,
                   'level' => $level,
                   'progress' => 0,
                   'json' => $jsonStartGame            
                   ));  

                 

                }

            }
            else
            {   //user is not logged in, as saved game will be used startgame json

                $savedGame = new SavedGame(['username' => '', 'category' => $category, 'level' => $level, 'progress' => 0, 'json' =>  $jsonStartGame]);
            }
        
            
     
          
         return view("game", compact('xmlToolbox', 'savedGame', 'jsonTasks', 'jsonModals'));
        
    }


      public function saveGame(Request $request)
    {      

        $data = $request->all(); 

         SavedGame::create(array('username' => $data['user'],
                   'category' => $data['category'],
                   'level' => $data['level'],
                   'progress' => $data['progress'],
                   'json' => $data['save']          
                   ));  



        //Log::debug('Some message.');
        //Log::debug($data);
        
    }

    public function updateIngameProgress(Request $request)
    {      

        $data = $request->all(); 
    
        $inGameProgress = IngameProgress::where('username', '=', $data['user'])->where('category', '=', $data['category'])->where('level', '=', $data['level'])->latest()->first();   

        if($inGameProgress!=null)
        {
          if($inGameProgress['progress'] < $data['progress'])
          {
            IngameProgress::updateOrCreate(['username' => $data['user'], 'category' => $data['category'],
            'level' => $data['level']], [ 
            'progress' => $data['progress']   
            ]);

          }

         

        }
        else
        {
            IngameProgress::updateOrCreate(['username' => $data['user'], 'category' => $data['category'],
            'level' => $data['level']], [ 
            'progress' => $data['progress']   
            ]);
        }


        
    }


    

}