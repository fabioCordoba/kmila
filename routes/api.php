<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);
Route::post('/register', [App\Http\Controllers\AuthController::class, 'register']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware'=>['auth:api']], function () {
    Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout']);

    //Route::post('/forgot', 'ForgotPasswordController@forgot');
    //Route::post('/reset', 'ForgotPasswordController@reset');
});

/*
| Api Route Capital
*/
Route::resource('capital', App\Http\Controllers\CapitalController::class);
Route::get('/capital/search/{select}/{param}', [App\Http\Controllers\CapitalController::class, 'search']);
Route::get('/capital/all/summary', [App\Http\Controllers\CapitalController::class, 'summary']);


Route::resource('finance', App\Http\Controllers\FinanceController::class);
Route::get('/finance/search/{select}/{param}', [App\Http\Controllers\FinanceController::class, 'search']);
Route::get('/finance/by/user/{user_id}', [App\Http\Controllers\FinanceController::class, 'financeByUser']);
Route::get('/user/by/finance/{finance_id}', [App\Http\Controllers\FinanceController::class, 'UserByFinance']);


Route::get('/test', function () {
    return response(
        User::all()
    );
});

