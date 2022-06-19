<?php

use App\Http\Controllers\Authentication\RedditOAuthController;
use App\Http\Controllers\ModerationActions\BansController;
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

/** Landing page */
Route::get('/', function () {
    if (auth()->check() && auth()->user()->can('access site')) {
        return redirect()->route('site.index');
    }
    return view('welcome');
});

Route::prefix('site')->name('site')->middleware('can:access site')->group(function () {

    Route::get('/', function () {
        return view('site.index', ['_pageTitle' => 'Start']);
    })->name('.index');

    /** Moderation actions */
    Route::prefix('moderation-actions')->name('.moderation-actions')->middleware('can:view moderation actions')->group(function () {

        /** Bans */
        Route::prefix('bans')->name('.bans')->controller(BansController::class)->group(function () {
            Route::get('/', 'index')->name('.index');
            Route::get('/{ban}', 'show')->name('.show');
        });

    });

});

/** Authentication */
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
