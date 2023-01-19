<?php

use App\Http\Controllers\Api\ModerationActions\MutesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/tokens/create', function (Request $request) {
    $token = $request->user()->createToken($request->token_name);

    return ['token' => $token->plainTextToken];
});

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('moderation-actions')->name('.moderation-actions')->group(function () {
        Route::resource('mutes', MutesController::class)->only(['index', 'show', 'store']);
    });
});
