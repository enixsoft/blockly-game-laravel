<?php
namespace App\Http\Controllers;
use Illuminate\Routing\Controller;

use Auth;

use Illuminate\Http\Request;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\User;


use App\Models\SavedGame;
use App\Models\IngameProgress;
use App\Models\Gameplay;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;

use Storage;

use Validator;

use Redirect;

use Log;

use DB;             

class GameController extends Controller
{    
      

    public function runGame($category, $level)  
    {                                   
        $categoryHasLevelsArray = array(6, 6); // maximum is increased +1 for last level redirect

        $categoryMin = 1;
        $categoryMax = sizeof($categoryHasLevelsArray);
        
        if($category <= $categoryMax && $category >= $categoryMin)
        {
         $levelMax=$categoryHasLevelsArray[$category-1];  
        }
        else
        {
         $levelMax=0;  
        }
       
        $levelMin=1;
  

        if($category>$categoryMax || $category<$categoryMin || $level < $levelMin || $level > $levelMax || !is_numeric($category) || !is_numeric($level))
        {
        abort(404);
        }
        else if($category==$categoryMax && $level==$levelMax)
        {
        return redirect()->route('/');
        }
        else
        {
        

            $xmlToolboxPath = "public/game" . "/" . $category . "x" . $level . "/toolbox" . $category . "x" . $level . ".xml";     
            $xmlToolbox = Storage::get($xmlToolboxPath);            
            
            $jsonStartGamePath = "public/game/". $category . "x" . $level . "/start" . $category . "x" . $level . ".json";
            $jsonStartGame = Storage::get($jsonStartGamePath);
            
            $jsonTasksPath = "public/game/". $category . "x" . $level . "/modals" . $category . "x" . $level . ".json";
            $jsonTasks = Storage::get($jsonTasksPath);

            $jsonModalsPath = "public/game/modals.json";
            $jsonModals = Storage::get($jsonModalsPath);


         

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
                 
                  if($level>1)
                  {
                  $inGameProgressOfPreviousLevel = IngameProgress::where('username', '=', $auth->username)->where('category', '=', $category)->where('level', '=', $level-1)->latest()->first();
                  if($inGameProgressOfPreviousLevel['progress']!=100)
                  {
                    return redirect()->route('/'); 
                  }
                  else
                  {
                    IngameProgress::create(['username' => $auth->username, 'category' => $category,
                    'level' => $level,  
                    'progress' => 0   
                    ]);

                    $savedGame = SavedGame::create(array('username' => $auth->username,
                   'category' => $category,
                   'level' => $level,
                   'progress' => 0,
                   'json' => $jsonStartGame            
                   ));  
                
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

            }
            else
            {   //user is not logged in, as saved game will be used startgame json

                //$savedGame = new SavedGame(['username' => '', 'category' => $category, 'level' => $level, 'progress' => 0, 'json' =>  $jsonStartGame]);

                return redirect()->route('/');
            }
        
            
     
          
         return view("game2", compact('category', 'level', 'xmlToolbox', 'savedGame', 'jsonTasks', 'jsonModals'));
        }
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
     public function createLogOfGameplay(Request $request)
    {   

      

      $data = $request->all();

      Log::debug('Some message.');
      Log::debug($data);      

      Gameplay::create([
            'username' => $data['username'], 
            'category' => $data['category'],
            'level' => $data['level'],  
            'level_start' => $data['level_start'],
            'task' => $data['task'],
            'task_start' => $data['task_start'],
            'task_end' => $data['task_end'],
            'task_elapsed_time' => $data['task_elapsed_time'],
            'code' => $data['code'],
            'result' => $data['result']
            ]);



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

      public function betaGetProgress()
    {      
          if(Auth::check())
            {
                
                $auth = Auth::user();

                $inGameProgress = IngameProgress::where('username', '=', $auth->username);


                return $inGameProgress;
            }

        
    }

          public function betaWelcome()
    {      
          if(Auth::check())
            {
                
                $auth = Auth::user();

                $inGameProgress = IngameProgress::where('username', '=', $auth->username)->get(['progress']);



                return view("welcome", compact('inGameProgress')); 
            }
           else
           {
             return view("welcome");
           } 

        
    }



   public function betaStartNewGameOrContinue()
    {      
          if(Auth::check())
            {
                
                $auth = Auth::user();

                $inGameProgress = IngameProgress::where('username', '=', $auth->username)->latest()->first();

                if($inGameProgress==null)
                {
                  //return $this->runGame(1,1);

                  return redirect()->route('game', ['category' => 1, 'level' => 1]);

                }
                else if($inGameProgress['progress']==100 && $inGameProgress['level']<5)
                {
                  
                    return redirect()->route('game', ['category' => 1, 'level' => $inGameProgress['level'] + 1]);
                }
                else  
                {
               
                    return redirect()->route('game', ['category' => 1, 'level' => $inGameProgress['level']]);
                }
                
            }
           else
           {
             return view("welcome");
           } 

        
    }

       public function betaStartLevelAsNew($category, $level)
    {      
          if(Auth::check())
            {
                $auth = Auth::user();

                $inGameProgress = IngameProgress::where('username', '=', $auth->username)->where('category', '=', $category)->where('level', '=', $level)->latest()->first();

                if($inGameProgress!= null && $inGameProgress['progress']==100)
                {
                
                $jsonStartGamePath = "public/game/". $category . "x" . $level . "/start" . $category . "x" . $level . ".json";
                $jsonStartGame = Storage::get($jsonStartGamePath);
                

                SavedGame::create(array('username' => $auth->username,
                   'category' => $category,
                   'level' => $level,
                   'progress' => 0,
                   'json' => $jsonStartGame            
                   ));  



                return redirect()->route('game', ['category' => $category, 'level' => $level]);
                }
                else 
                return view("welcome");
            }
           else
           {
             return view("welcome");
           } 

        
    }

    public function betaContinueLevel($category, $level)
    {      
          if(Auth::check())
            {

                $auth = Auth::user();

                $inGameProgress = IngameProgress::where('username', '=', $auth->username)->where('category', '=', $category)->where('level', '=', $level)->latest()->first();
                

                 if($inGameProgress!= null && $inGameProgress['progress']==100)
                {

                return redirect()->route('game', ['category' => $category, 'level' => $level]);

                }
                else           
                return view("welcome");
           

            }
           else
           {
             return view("welcome");
           } 

        
    }

    public function betaRegisterUser(Request $request)
    {
        if(Auth::check())
        {
        $auth = Auth::user();

        if($auth->role=="admin")
        {

        $user = new User();
        $user->username = $request['username'];
        $user->password = bcrypt($request['password']);
        $user->email = $request['username'] . '@blocklyhra.sk';
        $user->role = 'user';
        $user->remember_token = null;
        $user->save();
          
        return redirect()->route('/');
        } 
        else           
        return redirect()->route('/');

        }

        else
        {
        return redirect()->route('/');
        }
    }

    

}