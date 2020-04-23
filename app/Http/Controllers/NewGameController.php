<?php
namespace App\Http\Controllers;
use Illuminate\Routing\Controller;

use Auth;
use App;

use Illuminate\Http\Request;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Lang;

use App\Models\User;
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

class NewGameController extends Controller
{

    public function runGame($category, $level, Request $request)
    {
        $error = null;

        $categoryHasLevelsArray = array(
            6,
            6
        ); // maximum is increased +1 for last level redirect
        $categoryMin = 1;
        $categoryMax = sizeof($categoryHasLevelsArray);

        if ($category <= $categoryMax && $category >= $categoryMin)
        {
            $levelMax = $categoryHasLevelsArray[$category - 1];
        }
        else
        {
            $levelMax = 0;
        }

        $levelMin = 1;

        if ($category > $categoryMax || $category < $categoryMin || $level < $levelMin || $level > $levelMax || !is_numeric($category) || !is_numeric($level))
        {
            $error = "ERROR_WRONG_CATEGORY_OR_LEVEL";
            return $this->redirectOrSendResponse(compact('category', 'level', 'error') , $request);
        }
        else if ($category == $categoryMax && $level == $levelMax)
        {
            $error = "ERROR_WRONG_CATEGORY_OR_LEVEL";
            return $this->redirectOrSendResponse(compact('category', 'level', 'error') , $request);
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

            $jsonTasksPath = "public/game/" . $category . "x" . $level . "/" . $lang . "/" . "modals" . $category . "x" . $level . ".json";
            $jsonTasks = Storage::get($jsonTasksPath);

            $jsonRatingsPath = "public/game/" . $category . "x" . $level . "/" . "ratings" . $category . "x" . $level . ".json";
            $jsonRatings = Storage::get($jsonRatingsPath);

            $jsonModalsPath = "public/game/common" . "/" . $lang . "/" . "modals.json";
            $jsonModals = Storage::get($jsonModalsPath);

            $auth = Auth::user();

            $inGameProgress = Progress::where('username', '=', $auth->username)
                ->where('category', '=', $category)->latest()
                ->first();

            if ($inGameProgress == null) //game was not played at all or requested category was not played yet            
            {

                if ($category == 1)
                {

                    //no ingame progress in category 1 exists yet for this user, set level1 with 0 progress
                    Progress::create(['username' => $auth->username, 'category' => $category, 'level' => $level, 'progress' => 0]);

                    //no saved game in this category and level exists yet for this user, create first saved game with 0 progress from startgame json
                    $savedGame = SavedGame::create(array(
                        'username' => $auth->username,
                        'category' => $category,
                        'level' => $level,
                        'progress' => 0,
                        'json' => $jsonStartGame
                    ));

                }

                else
                {
                    //check if player has 100 progress in previous max level of previous category
                    $inGameProgressOfPreviousLevelOfPreviousCategory = Progress::where('username', '=', $auth->username)
                        ->where('category', '=', $category - 1)->where('level', '=', $categoryHasLevelsArray[$category - 1] - 1)->latest()
                        ->first();

                    if ($inGameProgressOfPreviousLevelOfPreviousCategory == null || $inGameProgressOfPreviousLevelOfPreviousCategory['progress'] != 100)
                    {
							 return $this->startNewGameOrContinue($request);
                    }
                    else
                    {
                        if ($level == 1)
                        {

                            Progress::create(['username' => $auth->username, 'category' => $category, 'level' => $level, 'progress' => 0]);

                            $savedGame = SavedGame::create(array(
                                'username' => $auth->username,
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

            else
            //progress for requested category exists            
            {

                if ($inGameProgress['level'] > $level)
                {

                    //if player has progress beyond the requested level
                    $savedGame = SavedGame::where('username', '=', $auth->username)
                        ->where('category', '=', $category)->where('level', '=', $level)->latest()
                        ->first();

                }

                else if ($inGameProgress['level'] == $level)
                {

                    //if player has progress on the par with requested level, has not completed it yet
                    if ($inGameProgress['progress'] != 100)
                    {

                        $savedGame = SavedGame::where('username', '=', $auth->username)
                            ->where('category', '=', $category)->where('level', '=', $level)->where('progress', '=', $inGameProgress['progress'])->latest()
                            ->first();

                        //if player due to error does not have the savedgame with progress he has, he gets the latest savedgame
                        if ($savedGame == null)
                        {
                            $savedGame = SavedGame::where('username', '=', $auth->username)
                                ->where('category', '=', $category)->where('level', '=', $level)->latest()
                                ->first();
                        }

                    }

                    //player has completed the level, but requests it again
                    else
                    {
                        $savedGame = SavedGame::where('username', '=', $auth->username)
                            ->where('category', '=', $category)->where('level', '=', $level)->latest()
                            ->first();

                    }

                }
                else if ($inGameProgress['level'] == $level - 1 && $inGameProgress['progress'] == 100)
                {

                    //if player has completed the level below requested level, update progress                    

                    $inGameProgress->update(['username' => $auth->username, 'category' => $category, 'level' => $level, 'progress' => 0]);

                    $savedGame = SavedGame::create(array(
                        'username' => $auth->username,
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
        return $this->redirectOrSendResponse(compact('category', 'level', 'xmlToolbox', 'xmlStartBlocks', 'savedGame', 'jsonTasks', 'jsonModals', 'jsonRatings') , $request);
    }

    public function saveGame(Request $request)
    {

        $data = $request->all();

        SavedGame::create(array(
            'username' => $data['user'],
            'category' => $data['category'],
            'level' => $data['level'],
            'progress' => $data['progress'],
            'json' => $data['save']
        ));

    }

    public function createLogOfGameplay(Request $request)
    {

        $data = $request->all();

        Gameplay::create(['username' => $data['username'], 'category' => $data['category'], 'level' => $data['level'], 'level_start' => $data['level_start'], 'task' => $data['task'], 'task_start' => $data['task_start'], 'task_end' => $data['task_end'], 'task_elapsed_time' => $data['task_elapsed_time'], 'rating' => $data['rating'], 'code' => $data['code'], 'result' => $data['result']]);

    }
    public function updateIngameProgress(Request $request)
    {

        $data = $request->all();

        $inGameProgress = Progress::where('username', '=', $data['user'])->where('category', '=', $data['category'])->latest()
            ->first();

        if ($inGameProgress != null)
        {

            if ($inGameProgress['level'] == $data['level'] && $inGameProgress['progress'] < $data['progress'])
            {

                $inGameProgress->update(['username' => $data['user'], 'category' => $data['category'], 'level' => $data['level'], 'progress' => $data['progress']]);

            }

        }

    }

    public function welcome($gameData = [])
    {
        $lang = App::getLocale();
        $langPath = "public/game/common/". $lang ."/app.json";
        $langJson = Storage::get($langPath);

        $inGameProgress = [];

        if (Auth::check())
        {
            $auth = Auth::user();

            $getProgress = Progress::where('username', '=', $auth->username)
                ->get();

            if ($getProgress != null)
            {
                foreach ($getProgress as $item)
                {

                    for ($i = 1;$i <= $item['level'];$i++)
                    {
                        if ($i == $item['level']) $inGameProgress[] = $item['progress'];
                        else $inGameProgress[] = 100;
                    }

                }

            }
        }

        $inGameProgressJson = json_encode($inGameProgress);
        $gameDataJson = json_encode($gameData);
        return view("vue", compact('inGameProgressJson', 'langJson', 'gameDataJson'));
    }

    public function startNewGameOrContinue(Request $request)
    {
        $auth = Auth::user();

        $inGameProgress = Progress::where('username', '=', $auth->username)
            ->latest()
            ->first();

        if ($inGameProgress == null)
        {
            return $this->runGame(1, 1, $request);
		}
		  
        else if ($inGameProgress['progress'] == 100)
        {
            return redirect()->route('game', ['category' => $inGameProgress['category'], 'level' => $inGameProgress['level'] + 1], 302, $request->headers->all());
        }

        else
        {
            return redirect()->route('game', ['category' => $inGameProgress['category'], 'level' => $inGameProgress['level']], 302, $request->headers->all());            
        }
    }

    public function startLevelAsNew($category, $level, Request $request)
    {

        $categoryHasLevelsArray = array(
            6,
            6
        );

        $categoryMin = 1;
        $categoryMax = sizeof($categoryHasLevelsArray);

        if ($category <= $categoryMax && $category >= $categoryMin)
        {
            $levelMax = $categoryHasLevelsArray[$category - 1];
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

        $auth = Auth::user();

        $inGameProgress = Progress::where('username', '=', $auth->username)
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
                'username' => $auth->username,
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
        $categoryHasLevelsArray = array(
            6,
            6
        );

        $categoryMin = 1;
        $categoryMax = sizeof($categoryHasLevelsArray);

        if ($category <= $categoryMax && $category >= $categoryMin)
        {
            $levelMax = $categoryHasLevelsArray[$category - 1];
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
            $auth = Auth::user();
            $inGameProgress = Progress::where('username', '=', $auth->username)
                ->where('category', '=', $category)->latest()
                ->first();

            if ($inGameProgress != null && $inGameProgress['level'] >= $level)
            {
                return $this->runGame($category, $level, $request);
            }
            else return $this->redirectOrSendResponse([],$request);
        }

    }

    public function registerUserByAdmin(Request $request)
    {
        $auth = Auth::user();

        if ($auth->role == "admin")
        {
            $user = new User();
            $user->username = $request['username'];
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
        $data = $request->all();

        Bug::create(['username' => $data['username'], 'category' => $data['category'], 'level' => $data['level'], 'report' => Str::substr($data['report'], 0, 1000) ]);
    }

    public function redirectOrSendResponse($responseData, Request $request)
    {	
        if ($request->expectsJson())
        {
            if(empty($responseData))
            {
                return response()->json(['error' => 'Internal Server Error'], 500);
            }
            return $responseData;
		  }
		  
		  if(empty($responseData))
		  {
			return redirect()->route('/');
		  }

        return $this->welcome($responseData);
    }

}

