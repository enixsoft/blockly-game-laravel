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

/*Route::get('/', function () {
    
   
 
  return view('welcome');


})->name('/');
*/
Route::get('/registration', function () {
    return view('registration');
});

/*Route::get('/game', function () {
     
    $xmlpath = "public/blockly_files/toolbox_level_0.xml";
    $xmltest = file_get_contents($xmlpath);



    return view('game', compact('xmltest'));
})->name('game');
*/

Route::get('/game/{category}/{level}', 'GameController@runGame')->name('game');
Route::post('/game/savegame', 'GameController@saveGame');
Route::post('/game/updateingameprogress', 'GameController@updateIngameProgress');

// BETA ================================================================================================
Route::get('/game/getProgress', 'GameController@betaGetProgress');
Route::get('/', 'GameController@betaWelcome')->name('/');


//Route::post('/game/saveGame', 'GameController@saveGame')->name('saveGame'); 

Auth::routes();

/*


    // Authentication Routes...
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Auth\LoginController@login');
    Route::post('logout', 'Auth\LoginController@logout');

    // Registration Routes...
    Route::get('register', 'Auth\RegisterController@showRegistrationForm');
    Route::post('register', 'Auth\RegisterController@register');

    // Password Reset Routes...
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');
*/



Route::get('/home', 'HomeController@index')->name('home');
