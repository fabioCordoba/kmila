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
    Route::get('/check-token', [App\Http\Controllers\AuthController::class, 'checkToken']);

    //* Api Route User
    Route::get('/user/by/relations/{id}', [App\Http\Controllers\AuthController::class, 'userByRelations']);


    //* Api Route Capital
    Route::resource('capital', App\Http\Controllers\CapitalController::class);
    Route::get('/capital/search/{select}/{param}', [App\Http\Controllers\CapitalController::class, 'search']);
    Route::get('/capital/all/summary', [App\Http\Controllers\CapitalController::class, 'summary']);


    //* Api Route Finances
    Route::resource('finance', App\Http\Controllers\FinanceController::class);
    Route::get('/finance/search/{select}/{param}', [App\Http\Controllers\FinanceController::class, 'search']);
    Route::get('/finance/by/relations/{id}', [App\Http\Controllers\FinanceController::class, 'FinanceByRelations']);

    //* Api Route Obligation
    Route::resource('obligation', App\Http\Controllers\ObligationController::class);
    Route::get('/obligation/search/{select}/{param}', [App\Http\Controllers\ObligationController::class, 'search']);
    Route::get('/obligation/by/relations/{id}', [App\Http\Controllers\ObligationController::class, 'obligationByRelations']);

    //* Api Route Payments
    Route::resource('payments', App\Http\Controllers\PaymentsController::class);
    Route::get('/payments/search/{select}/{param}', [App\Http\Controllers\PaymentsController::class, 'search']);
    Route::get('/payments/by/relations/{id}', [App\Http\Controllers\PaymentsController::class, 'paymentsByRelations']);

    Route::get('/test', function () {
        return response(
            User::all()
        );
    });

    //Route::post('/forgot', 'ForgotPasswordController@forgot');
    //Route::post('/reset', 'ForgotPasswordController@reset');
});


Route::get('/patient/{id}', function ($id) {

    $data = [
        "pat_type_id" => "CC",
        "pat_id" => "000111",
        "pat_name" =>"Test KV",
        "pat_birthdate" => "00000",
        "pat_sex" => "F"
    ];

    return response()->json($data,201);
});

