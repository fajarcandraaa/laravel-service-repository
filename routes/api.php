<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DocumentsController;
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

Route::group(['prefix' => 'v1'], function () {
    Route::controller(AuthController::class)->group(function() {
        Route::post('login', 'login')->name('login');
        Route::post('register', 'register')->name('register');
        Route::post('logout', 'logout')->name('logout');
        Route::post('refresh', 'refresh')->name('refresh');
    });

    Route::controller(DocumentsController::class)->group(function() {
        Route::post('/document','newDocument');
        Route::get('/document','listDocument');
        Route::get('/document/{id}','getDetailDocumentById');
        Route::put('/document/{id}','updateDocumentById');
        Route::delete('/document/{id}','documentDeleteById');
    });
});
