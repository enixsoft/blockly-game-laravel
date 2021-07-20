<?php
namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\SinglePageApplicationTrait;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SavedGame;
use App\Models\Progress;
use App\Models\Gameplay;
use App\Models\Bug;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

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
    
    public function runGame($category, $level, Request $request)
    {
        $user = Auth::user();

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

        if (!is_numeric($category) || !is_numeric($level) || $category > $categoryMax || $category < $categoryMin || $level < $levelMin || $level > $levelMax)
        {
            return $this->processRequest('home', [], $request, RouteServiceProvider::HOME);
        }
        else if ($category == $categoryMax && $level == $levelMax)
        {
            return $this->processRequest('home', [], $request, RouteServiceProvider::HOME);
        }
        else if ($category < $categoryMax && $level == $levelMax)
        {
            return $this->runGame($category + 1, $levelMin, $request);
        }
        else
        {
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

            $inGameProgress = optional($user->progress)->where('category', $category)->first();            

            if ($inGameProgress == null) // game was not played at all or requested category was not played yet            
            {
                if ($category == 1)
                {
                    // no ingame progress in category 1 exists yet for this user, set level1 with 0 progress
                    $user->progress()->create(['category' => $category, 'level' => $level, 'progress' => 0]);

                    // no saved game in this category and level exists yet for this user, create first saved game with 0 progress from startgame json
                    $savedGame = SavedGame::create(array(
                        'user_id' => $user->id,
                        'category' => $category,
                        'level' => $level,
                        'progress' => 0,
                        'json' => $jsonStartGame
                    ));
                }
                else
                {
                    // check if player has 100 progress in previous max level of previous category
                    $inGameProgressOfLastLevelOfPreviousCategory = $user->progress
                        ->where('category', '=', $category - 1)->where('level', '=', static::LEVELS_PER_CATEGORY[$category - 1] - 1);

                    if ($inGameProgressOfLastLevelOfPreviousCategory == null || $inGameProgressOfLastLevelOfPreviousCategory->progress != 100)
                    {
						return $this->startNewGameOrContinue($request);
                    }
                    else
                    {
                        if ($level == 1)
                        {
                            $user->progress()->create(['category' => $category, 'level' => $level, 'progress' => 0]);

                            $savedGame = SavedGame::create(array(
                                'user_id' => $user->id,
                                'category' => $category,
                                'level' => $level,
                                'progress' => 0,
                                'json' => $jsonStartGame
                            ));
                        }

                        else
                        {
                            return $this->runGame($category, 1, $request);
                        }
                    }
                }
            }
            else // progress for requested category exists                        
            {
                if ($inGameProgress->level > $level)
                {
                    // if player has progress beyond the requested level
                    $savedGame = SavedGame::where('user_id', '=', $user->id)
                        ->where('category', '=', $category)->where('level', '=', $level)->latest()
                        ->first();
                }
                else if ($inGameProgress->level == $level)
                {
                    // if player has progress on par with requested level, has not completed it yet
                    if ($inGameProgress->progress != 100)
                    {
                        $savedGame = SavedGame::where('user_id', '=', $user->id)
                            ->where('category', '=', $category)->where('level', '=', $level)->where('progress', '=', $inGameProgress->progress)->latest()
                            ->first();

                        // if player due to error does not have the savedgame with progress he has, he gets the latest savedgame
                        if ($savedGame == null)
                        {
                            $savedGame = SavedGame::where('user_id', '=', $user->id)
                                ->where('category', '=', $category)->where('level', '=', $level)->latest()
                                ->first();
                        }
                    }

                    // player has completed the level, but requests it again
                    else
                    {
                        $savedGame = SavedGame::where('user_id', '=', $user->id)
                            ->where('category', '=', $category)->where('level', '=', $level)->latest()
                            ->first();
                    }
                }
                else if ($inGameProgress->level == $level - 1 && $inGameProgress->progress == 100)
                {
                    // if player has completed the level below requested level, update progress                    

                    $inGameProgress->update(['category' => $category, 'level' => $level, 'progress' => 0]);
                    $savedGame = SavedGame::create(array(
                        'user_id' => $user->id,
                        'category' => $category,
                        'level' => $level,
                        'progress' => 0,
                        'json' => $jsonStartGame
                    ));
                }
                else
                {       
					return $this->startNewGameOrContinue($request);
                }
            }
        }
        $category = "$category";
        $level = "$level";
        return $this->processRequest('game', compact('category', 'level', 'xmlToolbox', 'xmlStartBlocks', 'savedGame', 'jsonTasks', 'jsonModals', 'jsonRatings'), $request);
    }

    public function saveGame(Request $request)
    {
        $user = Auth::user();

        $data = $request->all();

        SavedGame::create(array(
            'user_id' => $user->id,
            'category' => $data['category'],
            'level' => $data['level'],
            'progress' => $data['progress'],
            'json' => $data['save']
        ));
    }

    public function createLogOfGameplay(Request $request)
    {
        $user = Auth::user();

        $data = $request->all();

        Gameplay::create(['user_id' => $user->id, 'category' => $data['category'], 'level' => $data['level'], 'level_start' => $data['level_start'], 'task' => $data['task'], 'task_start' => $data['task_start'], 'task_end' => $data['task_end'], 'task_elapsed_time' => $data['task_elapsed_time'], 'rating' => $data['rating'], 'code' => $data['code'], 'result' => $data['result']]);

    }
    public function updateIngameProgress(Request $request)
    {
        $user = Auth::user();

        $data = $request->all();

        $inGameProgress = Progress::where('user_id', '=', $user->id)->where('category', '=', $data['category'])->latest()
            ->first();

        if ($inGameProgress != null)
        {
            if ($inGameProgress['level'] == $data['level'] && $inGameProgress['progress'] < $data['progress'])
            {
                $inGameProgress->update(['user_id' => $user->id, 'category' => $data['category'], 'level' => $data['level'], 'progress' => $data['progress']]);
            }

        }

    }

    public function startNewGameOrContinue(Request $request)    
    {
        $user = Auth::user();

        $inGameProgress = optional($user->progress)->first();

        if ($inGameProgress == null)
        {
            return $this->runGame(1, 1, $request);
		}		  
        else if ($inGameProgress->progress == 100)
        {
            return redirect()->route('game', ['category' => $inGameProgress->category, 'level' => $inGameProgress->level + 1], 302, $request->headers->all());
        }
        else
        {
            return redirect()->route('game', ['category' => $inGameProgress->category, 'level' => $inGameProgress->level], 302, $request->headers->all());            
        }
    }

    public function startLevelAsNew($category, $level, Request $request)
    {
        $user = Auth::user();

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

        if ($category > $categoryMax || $category < $categoryMin || $level < $levelMin || $level > $levelMax || !is_numeric($category) || !is_numeric($level))
        {
            return $this->redirectOrSendResponse([],$request);
        }

        $inGameProgress = Progress::where('user_id', '=', $user->id)
            ->where('category', '=', $category)->latest()
            ->first();

        if ($inGameProgress == null)
        {
            return $this->redirectOrSendResponse([],$request);
        }
        else if ($inGameProgress['level'] > $level || ($inGameProgress['level'] == $level && $inGameProgress['progress'] == 100))
        {

            $jsonStartGamePath = "public/game/" . $category . "x" . $level . "/start" . $category . "x" . $level . ".json";
            $jsonStartGame = Storage::get($jsonStartGamePath);

            SavedGame::create(array(
                'user_id' => $user->id,
                'category' => $category,
                'level' => $level,
                'progress' => 0,
                'json' => $jsonStartGame
            ));
        }

        return redirect()->route('game', ['category' => $category, 'level' => $level], 302, $request->headers->all());
    }

    public function continueLevel($category, $level, Request $request)
    {
        $user = Auth::user();

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

        if ($category > $categoryMax || $category < $categoryMin || $level < $levelMin || $level > $levelMax || !is_numeric($category) || !is_numeric($level))
        {
            return $this->redirectOrSendResponse([],$request);
        }
        else
        {
            $inGameProgress = Progress::where('user_id', '=', $user->id)
                ->where('category', '=', $category)->latest()
                ->first();

            if ($inGameProgress != null && $inGameProgress->level >= $level)
            {
                return $this->runGame($category, $level, $request);
            }
            else return $this->redirectOrSendResponse([],$request);
        }

    }

    public function registerUserByAdmin(Request $request)
    {
        $user = Auth::user();

        if ($user->role == "admin")
        {
            $user = new User();
            $user->name = $request['username'];
            $user->password = bcrypt($request['password']);
            $user->email = $request['username'] . '@blocklyhra.sk';
            $user->role = 'user';
            $user->remember_token = null;
            $user->save();
        }
        else return $this->redirectOrSendResponse([],$request);
    }

    public function reportBug(Request $request)
    {
        $user = Auth::user();

        $data = $request->all();

        Bug::create(['username' => $data['username'], 'category' => $data['category'], 'level' => $data['level'], 'report' => Str::substr($data['report'], 0, 1000) ]);
    }

}

