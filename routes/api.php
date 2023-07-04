<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserDocumentController;
use App\Http\Controllers\ArticleController;

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


Route::post('/document/store',[UserDocumentController::class,'store']);
Route::get('/document/download',[UserDocumentController::class,'download']);

Route::get('/articles/{id?}',[ArticleController::class,'index']);
Route::post('/articles',[ArticleController::class,'store']);
Route::put('/articles/{id}',[ArticleController::class,'update']);
Route::delete('/articles/{id}',[ArticleController::class,'delete']);

