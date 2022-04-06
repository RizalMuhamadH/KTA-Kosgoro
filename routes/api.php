<?php

use App\Http\Controllers\APIController;
use App\Http\Controllers\ComplimentaryController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\NewsController;
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
Route::post('/register',[MemberController::class,'register']);
Route::post('/generate_otp',[MemberController::class,'generate_otp']);
Route::post('/login/member',[MemberController::class,'login']);
Route::post('/update/member',[MemberController::class,'update']);
Route::post('/check_status/member',[MemberController::class,'check_status']);
Route::get('/detail/member',[MemberController::class,'detail']);
Route::get('/province',[ComplimentaryController::class,'getProvince']);
Route::get('/district',[ComplimentaryController::class,'getDistrict']);
Route::get('/subDistrict',[ComplimentaryController::class,'getSubDistrict']);
Route::get('/getVillage',[ComplimentaryController::class,'getVillage']);
Route::post('/news',[NewsController::class,'getNews']);
Route::post('/getNewsByCategory',[NewsController::class,'getNewsByCategory']);
Route::post('/readNews',[NewsController::class,'readNews']);
Route::post('/event',[EventController::class,'getEvent']);
Route::post('/getEventByCategory',[EventController::class,'getEventByCategory']);
Route::post('/readEvent',[EventController::class,'readEvent']);
