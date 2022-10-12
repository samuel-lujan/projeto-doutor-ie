<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\DownloadMediaController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'prefix' => 'v1',
], function() {

    Route::post('user', [AuthController::class, 'store']);
    Route::post('auth/token', [AuthController::class, 'login']);


    Route::group(['middleware' => ['auth:sanctum']], function(){
        Route::get('livros', [BookController::class, 'index']);
        Route::post('livros', [BookController::class, 'store']);
        Route::get('livros/{book}', [BookController::class, 'show']);
        Route::put('livros/{book}', [BookController::class, 'update']);
        Route::get('livros/{book}.pdf', [DownloadMediaController::class, 'show']);
        Route::delete('livros/{book}', [BookController::class, 'delete']);
    });

});
