<?php
namespace App\Http\Controllers;
use Illuminate\Routing\Controller;

use Auth;

use Illuminate\Http\Request;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use App\User;


use App\Models\SavedGame;
use App\Models\Progress;
use App\Models\Gameplay;
use App\Models\Bug;

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
        else if ($category<$categoryMax && $level==$levelMax) 
        {
          return redirect()->route('game', ['category' => $category + 1, 'level' => $levelMin]);
        }
        else
        {
        

            $xmlToolboxPath = "public/game" . "/" . $category . "x" . $level . "/toolbox" . $category . "x" . $level . ".xml";     
            $xmlToolbox = Storage::get($xmlToolboxPath);            
            
            $jsonStartGamePath = "public/game/". $category . "x" . $level . "/start" . $category . "x" . $level . ".json";
            $jsonStartGame = Storage::get($jsonStartGamePath);
            
            $jsonTasksPath = "public/game/". $category . "x" . $level . "/modals" . $category . "x" . $level . ".json";
            $jsonTasks = Storage::get($jsonTasksPath);

            $jsonRatingsPath = "public/game/". $category . "x" . $level . "/ratings" . $category . "x" . $level . ".json";
            $jsonRatings = Storage::get($jsonRatingsPath);            

            $jsonModalsPath = "public/game/modals.json";
            $jsonModals = Storage::get($jsonModalsPath);


         

           if(Auth::check())
           {
                
                $auth = Auth::user();

                $inGameProgress = Progress::where('username', '=', $auth->username)->where('category', '=', $category)->latest()->first();

            
            if($inGameProgress==null) //game was not played at all or requested category was not played yet
            {
                  

                if($category==1)
                {


                   //no ingame progress in category 1 exists yet for this user, set level1 with 0 progress
                    
                   Progress::create(['username' => $auth->username, 'category' => $category,
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
                    
                 else
                  {
                     //check if player has 100 progress in previous max level of previous category
                     
                     $inGameProgressOfPreviousLevelOfPreviousCategory = Progress::where('username', '=', $auth->username)->where('category', '=', $category-1)->where('level', '=', $categoryHasLevelsArray[$category-1]-1)->latest()->first();

                     
                     if($inGameProgressOfPreviousLevelOfPreviousCategory == null || $inGameProgressOfPreviousLevelOfPreviousCategory['progress']!=100)                      
                     {
                         return redirect()->route('play');
                     }
                     else
                     {
                          if($level==1)
                          {     

                          
                          Progress::create(['username' => $auth->username, 'category' => $category,
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

                         else
                         {
                           return redirect()->route('game', ['category' => $category, 'level' => 1]);

                         }



                     }


                  }

             }

             else //progress for requested category exists                
             {

                  if ($inGameProgress['level'] > $level) 
                  {

                     //if player has progress beyond the requested level

                     $savedGame = SavedGame::where('username', '=', $auth->username)->where('category', '=', $category)->where('level', '=', $level)->latest()->first();   

                  }

                  else if($inGameProgress['level'] == $level) 
                  { 

                       //if player has progress on the par with requested level, has not completed it yet

                      if($inGameProgress['progress']!=100)
                      {

                      $savedGame = SavedGame::where('username', '=', $auth->username)->where('category', '=', $category)->where('level', '=', $level)->where('progress', '=', $inGameProgress['progress'])->latest()->first();

                      }
                      
                      //player has completed the level, but requests it again

                      else
                      {
                        $savedGame = SavedGame::where('username', '=', $auth->username)->where('category', '=', $category)->where('level', '=', $level)->latest()->first();   

                      }



                  }
                  else if($inGameProgress['level'] == $level-1 && $inGameProgress['progress']==100)
                  {

                    //if player has completed the level below requested level, update progress

                    
                    $inGameProgress->update(['username' => $auth->username, 'category' => $category,
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
                  else                  
                  {
                      return redirect()->route('play'); 

                  }


            }   
          
          }
          else
          {   

                //user is not logged in

                return redirect()->route('/');
          }
        
            
     
         } 
         return view("game", compact('category', 'level', 'xmlToolbox', 'savedGame', 'jsonTasks', 'jsonModals', 'jsonRatings'));
        
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


        
    }

    public function createLogOfGameplay(Request $request)
    {   

      

      $data = $request->all();

   

      Gameplay::create([
            'username' => $data['username'], 
            'category' => $data['category'],
            'level' => $data['level'],  
            'level_start' => $data['level_start'],
            'task' => $data['task'],
            'task_start' => $data['task_start'],
            'task_end' => $data['task_end'],
            'task_elapsed_time' => $data['task_elapsed_time'],
            'rating' => $data['rating'],
            'code' => $data['code'],
            'result' => $data['result']
            ]);



    }
    public function updateIngameProgress(Request $request)
    {      

        $data = $request->all(); 
    
        $inGameProgress = Progress::where('username', '=', $data['user'])->where('category', '=', $data['category'])->latest()->first();   

        
        if($inGameProgress!=null)                 
        {
          
          if($inGameProgress['level'] == $data['level'] && $inGameProgress['progress'] < $data['progress'])
          {

            $inGameProgress->update(['username' => $data['user'], 
            'category' => $data['category'],
            'level' => $data['level'], 
            'progress' => $data['progress']   
            ]);

          }
         
        }



        
    }


    public function welcome()
    {      
          if(Auth::check())
            {
                
                $auth = Auth::user();                

                $getProgress = Progress::where('username', '=', $auth->username)->get();

                $inGameProgress = [];

                if($getProgress!=null)
                {

                
                  foreach($getProgress as $item)
                  {
                  
                  for ($i=1; $i <= $item['level']; $i++) 
                  { 
                     if($i==$item['level'])
                     $inGameProgress[] = $item['progress'];
                     else
                     $inGameProgress[] = 100;
                  }

                  }

                }   





                return view("welcome", compact('inGameProgress')); 
            }
           else
           {
             return view("welcome");
           } 

        
    }



   public function startNewGameOrContinue()
    {      
          if(Auth::check())
            {
                
                $auth = Auth::user();

                $inGameProgress = Progress::where('username', '=', $auth->username)->latest()->first();

                if($inGameProgress==null)
                {                 

                  return redirect()->route('game', ['category' => 1, 'level' => 1]);

                }
                else if($inGameProgress['progress']==100)
                {
                  
                    return redirect()->route('game', ['category' => $inGameProgress['category'], 'level' => $inGameProgress['level'] + 1]);
                }

                else  
                {
               
                    return redirect()->route('game', ['category' => $inGameProgress['category'], 'level' => $inGameProgress['level']]);
                }
                
            }
           else
           {
             return redirect()->route('/');
           } 

        
    }

       public function startLevelAsNew($category, $level)
    {      
          if(Auth::check())
            {
                $auth = Auth::user();

                $inGameProgress = Progress::where('username', '=', $auth->username)->where('category', '=', $category)->latest()->first();

                if($inGameProgress != null && $inGameProgress['level']>=$level)
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
                return redirect()->route('/');
            }
           else
           {
              return redirect()->route('/');
           } 

        
    }

    public function continueLevel($category, $level)
    {      
          if(Auth::check())
            {

                $auth = Auth::user();

                $inGameProgress = Progress::where('username', '=', $auth->username)->where('category', '=', $category)->latest()->first();
                

                if($inGameProgress!= null && $inGameProgress['level']>=$level)
                {

                return redirect()->route('game', ['category' => $category, 'level' => $level]);

                }
                else           
                return redirect()->route('/');
           

            }
           else
           {
              return redirect()->route('/');
           } 

        
    }

    public function registerUserByAdmin(Request $request)
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
        return redirect()->route('/');
      
    }


    public function reportBug(Request $request)
    {

      $data = $request->all();     

      Bug::create([
            'username' => $data['username'], 
            'category' => $data['category'],
            'level' => $data['level'],  
            'report' => Str::substr($data['report'], 0, 1000) 
            ]);
    }

    

}