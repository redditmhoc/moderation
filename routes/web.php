<?php

use App\Http\Controllers\Authentication\LogoutController;
use App\Http\Controllers\Authentication\RedditOAuthController;
use App\Http\Controllers\ImageAttachmentsController;
use App\Http\Controllers\ModerationActions\BansController;
use App\Http\Controllers\ModerationActions\MutesController;
use App\Http\Controllers\NotesController;
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
Route::get('/', function (\Illuminate\Http\Request $request) {
    if (auth()->check() && auth()->user()->can('access site') && ! $request->has('sR')) {
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
            Route::get('/create', 'create')->name('.create');
            Route::post('/store', 'store')->name('.store');
            Route::get('/{ban}/edit', 'edit')->name('.edit');
            Route::post('/{ban}/edit', 'update')->name('.update');
            Route::post('/{ban}/overturn', 'overturn')->name('.overturn');
            Route::post('/{ban}/delete', 'delete')->name('.delete');
            Route::get('/{ban}', 'show')->name('.show');
        });

        /** Mutes */
        Route::prefix('mutes')->name('.mutes')->controller(MutesController::class)->group(function () {
            Route::get('/', 'index')->name('.index');
            Route::get('/create', 'create')->name('.create');
            Route::post('/store', 'store')->name('.store');
            Route::get('/{mute}/edit', 'edit')->name('.edit');
            Route::post('/{mute}/edit', 'update')->name('.update');
            Route::post('/{mute}/delete', 'delete')->name('.delete');
            Route::get('/{mute}', 'show')->name('.show');
        });

    });

    /** Notes */
    Route::prefix('notes')->name('.notes')->controller(NotesController::class)->group(function () {
        Route::get('/', 'index')->name('.index');
        Route::get('/create', 'create')->name('.create');
        Route::post('/store', 'store')->name('.store');
        Route::get('/{note}/edit', 'edit')->name('.edit');
        Route::post('/{note}/edit', 'update')->name('.update');
        Route::post('/{note}/delete', 'delete')->name('.delete');
        Route::get('/{note}', 'show')->name('.show');
    });

    Route::resource('image-attachments', ImageAttachmentsController::class)->only(
        ['create', 'destroy']
    )->names([
        'create' => '.image-attachments.create', 'destroy' => '.image-attachments.destroy'
    ]);

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

    Route::get('/logout', LogoutController::class)->name('.logout');

});
Route::impersonate();
