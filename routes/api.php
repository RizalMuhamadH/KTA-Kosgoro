<?php

use App\Http\Controllers\APIController;
use App\Http\Controllers\MemberController;
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


Route::post('/create/member',[MemberController::class,'store']);
Route::post('/generate_otp',[MemberController::class,'generate_otp']);
Route::post('/login/member',[MemberController::class,'login']);
Route::post('/update/member',[MemberController::class,'update']);
Route::get('/detail/member',[MemberController::class,'detail']);
