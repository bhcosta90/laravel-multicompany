<?php

use Illuminate\Support\Facades\Route;
use Modules\Central\Http\Controllers\Api\{CompanyController, TransactionController};

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

Route::group(['prefix' => 'central'], function(){
    Route::resource('company', CompanyController::class)->only(['index', 'show', 'store', 'destroy']);
});