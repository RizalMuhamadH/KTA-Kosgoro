<?php

use App\Http\Controllers\MemberController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
Route::post('/member/login',[MemberController::class,'login'])->name('member_login');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('/members')->name('members.')->group(function () {
    Route::get('/',[MemberController::class, 'detail'])->name('detail');
});
Route::post('/generate_otp',[MemberController::class,'generate_otp'])->name('generate_otp');
