<?php

use App\Http\Controllers\Authentication\RedditOAuthController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('auth')->name('auth')->group(function () {

   /** OAuth */
    Route::prefix('oauth')->name('.oauth')->group(function () {

       /**
        * Reddit
        */
       Route::prefix('reddit')->name('.reddit')->controller(RedditOAuthController::class)->group(function () {
           Route::get('/login', 'login')->name('.login');
           Route::get('/callback', 'callback')->name('.callback');
       });

    });

});
