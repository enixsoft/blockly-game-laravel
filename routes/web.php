<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Illuminate\Http\Request;
use App\Http\Controllers\GameController;


Route::group(['middleware' => ['auth', 'lang'] ], function()
{
//POST
Route::post('registeruserbyadmin', 'GameController@registerUserByAdmin')->name('registeruserbyadmin');
Route::post('/game/savegame', 'GameController@saveGame');
Route::post('/game/updateingameprogress', 'GameController@updateIngameProgress');
Route::post('/game/createlogofgameplay', 'GameController@createLogOfGameplay');
Route::post('/game/reportbug', 'GameController@reportBug');

//GET
Route::get('/game/{category}/{level}', 'GameController@runGame')->name('game');
Route::get('/play', 'GameController@startNewGameOrContinue')->name('play');
Route::get('/start/{category}/{level}', 'GameController@startLevelAsNew')->name('start');
Route::get('/continue/{category}/{level}', 'GameController@continueLevel')->name('continue');
});

Route::get('/', 'GameController@welcome')->name('/');

// Authentication Routes
Route::post('login', 'Auth\LoginController@login')->name('login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
Route::post('register', 'Auth\RegisterController@register')->name('register');

Route::get('/language/{lang}', 'LanguageController@setLanguage');




/* 
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::get('register', 'Auth\RegisterController@showRegistrationForm');
*/

/* Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');
*/


