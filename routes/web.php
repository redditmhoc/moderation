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

Route::get('/', function () {
    if (Auth::check() && Auth::user()->can('access')) {
        return redirect()->route('dash');
    }
    return view('welcome');
})->name('welcome');

Route::prefix('auth')->group(function () {
    Route::get('login', 'AuthController@redditLogin')->name('auth.login');
    Route::get('callback', 'AuthController@redditCallback')->name('auth.callback');
    Route::get('logout', function() {
        Auth::logout();
        return redirect()->route('welcome');
    })->name('auth.logout');
});

Route::get('/dash', 'ViewsController@dash')->name('dash');
Route::view('/guidance', 'guidance')->name('guidance');
Route::prefix('actions')->group(function () {
    Route::get('create/ban', 'ActionsController@createBan')->middleware('permission:create ban')->name('actions.createban');
    Route::post('create/ban', 'ActionsController@createBanPost')->middleware('permission:create ban')->name('actions.createban.post');
    Route::get('view/bans', 'ActionsController@viewAllBans')->middleware('permission:view actions')->name('actions.viewallbans');
    Route::get('view/ban/{reddit_username}/{id}', 'ActionsController@viewBan')->middleware('permission:view actions')->name('actions.viewban');
    Route::post('overturn/ban/{reddit_username}/{id}', 'ActionsController@overturnBan')->middleware('permission:overturn ban')->name('actions.overturnban');
    Route::post('import/bans', 'ActionsController@importBansFromFile')->middleware('role:admin')->name('actions.importbans');

    Route::get('create/warning', 'ActionsController@createWarning')->middleware('permission:create warning')->name('actions.createwarning');
    Route::post('create/warning', 'ActionsController@createWarningPost')->middleware('permission:create warning')->name('actions.createwarning.post');
    Route::get('view/warnings', 'ActionsController@viewAllWarnings')->middleware('permission:view actions')->name('actions.viewallwarnings');
    Route::get('view/warning/{reddit_username}/{id}', 'ActionsController@viewWarning')->middleware('permission:view actions')->name('actions.viewwarning');
});

Route::prefix('admin')->group(function () {
    Route::get('permissions', 'AdminController@managePermissions')->middleware('role:admin')->name('admin.managepermissions');
    Route::post('permissions/assignrole', 'AdminController@assignRoleAjax')->middleware('role:admin')->name('admin.assignrole');
    Route::post('permissions/removerole', 'AdminController@removeRoleAjax')->middleware('role:admin')->name('admin.removerole');
    Route::post('permissions/searchuserinfo', 'AdminController@searchUserInfoAjax')->middleware('role:admin')->name('admin.searchuserinfo');
});

Route::prefix('utility')->group(function () {
    Route::post('checkuserhistory', 'ActionsController@checkUserHistoryAjax')->middleware('permission:view actions')->name('utility.checkuserhistory');
});
