<?php
namespace App\Http\Controllers;

use App\Http\Requests\LogGameplayRequest;
use App\Http\Requests\RegisterUserByAdminRequest;
use App\Http\Requests\ReportBugRequest;
use App\Http\Requests\SaveGameRequest;
use App\Http\Requests\UpdateProgressRequest;
use Illuminate\Routing\Controller;
use App\Http\Traits\SinglePageApplicationTrait;
use Illuminate\Http\Request;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Auth\Authenticatable;

class GameController extends Controller
{    
    use SinglePageApplicationTrait;

    /**  
    * @var array
    * levels are increased +1 to enable last level redirect
    */
    const LEVELS_PER_CATEGORY = [
        6,
        6
    ];
        
    /**
     * Prepares data and runs game for specific category and level
     *
     * @param  string $category
     * @param  string $level
     * @param  Authenticatable $user
     * @param  Request $request
     * @return void
     */
    public function runGame($category, $level, Authenticatable $user, Request $request)
    {
        // if invalid category or invalid level, or max category and max level has been reached, redirect to home
        if (!$this->validateCategoryAndLevel($category, $level) 
            || ($category == sizeof(static::LEVELS_PER_CATEGORY) && $level == static::LEVELS_PER_CATEGORY[$category - 1]))        
        {
            return $this->redirectToRoute(RouteServiceProvider::HOME, [], $request);
        }

        // if category has been completed and there is next category, start first level of next category
        if ($category < sizeof(static::LEVELS_PER_CATEGORY) && $level == static::LEVELS_PER_CATEGORY[$category - 1])
        {
            return $this->runGame($category + 1, 1, $user, $request);
        }

        $lang = App::getLocale();

        $xmlToolboxPath = "public/game" . "/" . $category . "x" . $level . "/" . "toolbox" . $category . "x" . $level . ".xml";
        $xmlToolbox = Storage::get($xmlToolboxPath);
        
        $xmlStartBlocksPath = "public/game/common" . "/" . "xmlStartBlocks" . $category . ".xml";
        $xmlStartBlocks = Storage::get($xmlStartBlocksPath);

        $jsonStartGamePath = "public/game/" . $category . "x" . $level . "/" . "start" . $category . "x" . $level . ".json";
        $jsonStartGame = Storage::get($jsonStartGamePath);

        $jsonTasksPath = "public/game/" . $category . "x" . $level . "/" . "modals" . $category . "x" . $level . ".json";
        $jsonTasks = Storage::get($jsonTasksPath);

        $jsonRatingsPath = "public/game/" . $category . "x" . $level . "/" . "ratings" . $category . "x" . $level . ".json";
        $jsonRatings = Storage::get($jsonRatingsPath);

        $jsonModalsPath = "public/game/common" . "/" . "modals.json";
        $jsonModals = Storage::get($jsonModalsPath);

        $inGameProgress = $user->progress()->where('category', $category)->first();            

        if ($inGameProgress == null) // game was not played at all or requested category was not played yet            
        {
            if ($category == 1)
            {
                // no ingame progress in category 1 exists yet for this user, set level1 with 0 progress
                $user->progress()->create(['category' => $category, 'level' => $level, 'progress' => 0]);

                // no saved game in this category and level exists yet for this user, create first saved game with 0 progress from startgame json
                $savedGame = $user->savedGames()->create([
                    'category' => $category,
                    'level' => $level,
                    'progress' => 0,
                    'json' => $jsonStartGame
                ]);
            }
            else
            {
                // check if player has 100 progress in previous max level of previous category
                $inGameProgressOfLastLevelOfPreviousCategory = $user->progress()
                    ->where('category', '=', $category - 1)->where('level', '=', static::LEVELS_PER_CATEGORY[$category - 1] - 1)->first();

                if ($inGameProgressOfLastLevelOfPreviousCategory == null || $inGameProgressOfLastLevelOfPreviousCategory->progress != 100)
                {
                    return $this->startNewGameOrContinue($user, $request);
                }
                else
                {
                    if ($level == 1)
                    {
                        $user->progress()->create(['category' => $category, 'level' => $level, 'progress' => 0]);

                        $savedGame = $user->savedGames()->create([
                            'category' => $category,
                            'level' => $level,
                            'progress' => 0,
                            'json' => $jsonStartGame
                        ]);
                    }

                    else
                    {
                        return $this->runGame($category, 1, $user, $request);
                    }
                }
            }
        }
        else // progress for requested category exists                        
        {
            if ($inGameProgress->level > $level)
            {
                // if player has progress beyond the requested level
                $savedGame = $user->savedGames()->where('category', '=', $category)->where('level', '=', $level)->latest()->first();
            }
            else if ($inGameProgress->level == $level)
            {
                // if player has progress on par with requested level, has not completed it yet
                if ($inGameProgress->progress != 100)
                {
                    $savedGame = $user->savedGames()->where('category', '=', $category)->where('level', '=', $level)->where('progress', '=', $inGameProgress->progress)->latest()->first();

                    // if player due to error does not have the savedgame with progress he has, he gets the latest savedgame
                    if ($savedGame == null)
                    {
                        $savedGame = $user->savedGames()->where('category', '=', $category)->where('level', '=', $level)->latest()->first();                            
                    }
                }

                // player has completed the level, but requests it again
                else
                {
                    $savedGame = $user->savedGames()->where('category', '=', $category)->where('level', '=', $level)->latest()->first();
                }
            }
            else if ($inGameProgress->level == $level - 1 && $inGameProgress->progress == 100)
            {
                // if player has completed the level below requested level, update progress
                $inGameProgress->update(['category' => $category, 'level' => $level, 'progress' => 0]);                    
                
                $savedGame = $user->savedGames()->create([
                    'category' => $category,
                    'level' => $level,
                    'progress' => 0,
                    'json' => $jsonStartGame
                ]);
            }
            else
            {       
                return $this->startNewGameOrContinue($user, $request);
            }
        }
        
        $category = "$category";
        $level = "$level";
        return $this->processRequest('game', compact('category', 'level', 'xmlToolbox', 'xmlStartBlocks', 'savedGame', 'jsonTasks', 'jsonModals', 'jsonRatings'), $request);
    }
    
    /**
     * Saves game for user
     *
     * @param  Authenticatable $user
     * @param  SaveGameRequest $request
     * @return void
     */
    public function saveGame(Authenticatable $user, SaveGameRequest $request)
    {
        $user->savedGames()->create([
            'category' => $request['category'],
            'level' => $request['level'],
            'progress' =>  $request['progress'],
            'json' => $request['json']
        ]);

        return $this->successApiResponse();
    }
    
    /**
     * Logs gameplay of user
     *
     * @param  Authenticatable $user
     * @param  LogGameplayRequest $request
     * @return void
     */
    public function createLogOfGameplay(Authenticatable $user, LogGameplayRequest $request)
    {
        $user->gameplay()->create([
            'category' => $request['category'], 
            'level' => $request['level'], 
            'level_start' => $request['level_start'], 
            'task' => $request['task'], 
            'task_start' => $request['task_start'], 
            'task_end' => $request['task_end'], 
            'task_elapsed_time' => $request['task_elapsed_time'], 
            'rating' => $request['rating'], 
            'code' => $request['code'], 
            'result' => $request['result']
        ]);

        return $this->successApiResponse();
    }
        
    /**
     * Updates in-game progress of user
     *
     * @param  Authenticatable $user
     * @param  UpdateProgressRequest $request
     * @return void
     */
    public function updateIngameProgress(Authenticatable $user, UpdateProgressRequest $request)
    {
        $inGameProgress = $user->progress()->where('category', '=', $request['category'])->first();

        if ($inGameProgress != null)
        {
            if ($inGameProgress->level == $request['level'] && $inGameProgress->progress < $request['progress'])
            {
                $inGameProgress->update([
                    'category' => $request['category'], 
                    'level' => $request['level'], 
                    'progress' => $request['progress']
                ]);
            }
        }

        return $this->successApiResponse();
    }
    
    /**
     * Starts game from beginning or continues it based on recent progress
     *
     * @param  Authenticatable $user
     * @param  Request $request
     * @return void
     */
    public function startNewGameOrContinue(Authenticatable $user, Request $request)    
    {     
        $inGameProgress = $user->progress()->latest()->first();

        if ($inGameProgress == null)
        {
            return $this->runGame(1, 1, $user, $request);
		}		  
        else if ($inGameProgress->progress == 100)
        {
            return $this->redirectToRoute('game', ['category' => $inGameProgress->category, 'level' => $inGameProgress->level + 1], $request);
        }
        else
        {
            return $this->redirectToRoute('game', ['category' => $inGameProgress->category, 'level' => $inGameProgress->level], $request);    
        }
    }
    
    /**
     * Starts selected level of category from beginning 
     * by creating new saved game
     *
     * @param  string $category
     * @param  string $level
     * @param  Authenticatable $user
     * @param  Request $request
     * @return void
     */
    public function startLevelAsNew($category, $level, Authenticatable $user, Request $request)
    {
        if (!$this->validateCategoryAndLevel($category, $level))
        {
            return $this->redirectToRoute(RouteServiceProvider::HOME, [], $request);
        }

        $inGameProgress = $user->progress()->where('category', '=', $category)->first();

        if ($inGameProgress == null)
        {
            return $this->redirectToRoute(RouteServiceProvider::HOME, [], $request);
        }
        else if ($inGameProgress->level > $level || ($inGameProgress->level == $level && $inGameProgress->progress == 100))
        {              
            $jsonStartGamePath = "public/game/" . $category . "x" . $level . "/start" . $category . "x" . $level . ".json";
            $jsonStartGame = Storage::get($jsonStartGamePath);

            $user->savedGames()->create([
                'category' => $category,
                'level' => $level,
                'progress' => 0,
                'json' => $jsonStartGame        
            ]);
        }

        return $this->redirectToRoute('game', ['category' => $category, 'level' => $level], $request);
    }
    
    /**
     * Continues level based on recent progress
     *
     * @param  string $category
     * @param  string $level
     * @param  Authenticatable $user
     * @param  Request $request
     * @return void
     */
    public function continueLevel($category, $level, Authenticatable $user, Request $request)
    {
        if (!$this->validateCategoryAndLevel($category, $level))
        {
            return $this->redirectToRoute(RouteServiceProvider::HOME, [], $request);
        }
        
        $inGameProgress = $user->progress()
            ->where('category', '=', $category)
            ->first();

        if ($inGameProgress != null && $inGameProgress->level >= $level)
        {
            return $this->redirectToRoute('game', ['category' => $category, 'level' => $level], $request);
        }
        else 
        {            
            return $this->redirectToRoute(RouteServiceProvider::HOME, [], $request);
        }        
    }
    
    /**
     * Registers new user for administrator
     *
     * @param  Authenticatable $user
     * @param  RegisterUserByAdminRequest $request
     * @return void
     */
    public function registerUserByAdmin(Authenticatable $user, RegisterUserByAdminRequest $request)
    {
        if ($user->role == "admin")
        {
            $user = new User();
            $user->name = $request['username'];
            $user->password = bcrypt($request['password']);
            $user->email = $request['username'] . '@blocklyhra.sk';
            $user->role = 'user';
            $user->remember_token = null;
            $user->save();

            return $this->successApiResponse();
        }

        return $this->redirectToRoute(RouteServiceProvider::HOME, [], $request);              
    }
    
    /**
     * Saves report of bug provided by user
     *
     * @param  mixed $user
     * @param  mixed $request
     * @return void
     */
    public function reportBug(Authenticatable $user, ReportBugRequest $request)
    {
        $user->bugs()->create([
            'category' => $request['category'], 
            'level' => $request['level'], 
            'report' => $request['report']
        ]);

        return $this->successApiResponse();
    }
    
    /**
     * Validates category and level
     *
     * @param  string $category
     * @param  string $level
     * @return bool
     */
    private function validateCategoryAndLevel($category, $level) 
    {
        if (!is_numeric($category) || !is_numeric($level))
        {
            return false;
        }        
        
        $categoryMin = 1;
        $categoryMax = sizeof(static::LEVELS_PER_CATEGORY);

        if ($category <= $categoryMax && $category >= $categoryMin)
        {
            $levelMax = static::LEVELS_PER_CATEGORY[$category - 1];
        }
        else
        {
            $levelMax = 0;
        }

        $levelMin = 1;

        if ($category > $categoryMax || $category < $categoryMin 
            || $level < $levelMin || $level > $levelMax)
        {
            return false;
        }

        return true;
    }
}
