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
use App\Http\Controllers\NewGameController;


Route::group(['middleware' => ['auth', 'lang'] ], function()
{
//POST
Route::post('registeruserbyadmin', 'NewGameController@registerUserByAdmin')->name('registeruserbyadmin');
Route::post('/game/savegame', 'NewGameController@saveGame');
Route::post('/game/updateingameprogress', 'NewGameController@updateIngameProgress');
Route::post('/game/createlogofgameplay', 'NewGameController@createLogOfGameplay');
Route::post('/game/reportbug', 'NewGameController@reportBug');

//GET
Route::get('/game/{category}/{level}', 'NewGameController@runGame')->name('game');
Route::get('/play', 'NewGameController@startNewGameOrContinue')->name('play');
Route::get('/start/{category}/{level}', 'NewGameController@startLevelAsNew')->name('start');
Route::get('/continue/{category}/{level}', 'NewGameController@continueLevel')->name('continue');
});

Route::get('/', 'NewGameController@welcome')->name('/');

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


