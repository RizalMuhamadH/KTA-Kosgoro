<?php

use App\Http\Controllers\CategoryEventController;
use App\Http\Controllers\CategoryNewsController;
use App\Http\Controllers\ComplimentaryController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PWAController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

Route::get('/', [App\Http\Controllers\PWAController::class, 'index']);
Route::get('/admin',[HomeController::class,'index'])->name('admin_home')->middleware(['admin']);
Route::post('/member/login',[MemberController::class,'login'])->name('member_login');
Route::post('/generate_otp',[MemberController::class,'generate_otp'])->name('generate_otp');
Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware(['admin']);
    Route::prefix('/members')->name('members.')->group(function () {
        Route::get('/',[MemberController::class,'index'])->name('index');
        Route::post('/store',[MemberController::class,'store'])->name('store');
        Route::put('/update',[MemberController::class,'update'])->name('update');
        Route::put('/change_status',[MemberController::class,'change_status'])->name('change_status');
        Route::get('/datatables',[MemberController::class,'datatables'])->name('datatables');
        Route::get('/detail',[MemberController::class, 'detail'])->name('detail');
        Route::get('/dashboard',[MemberController::class,'dashboard'])->name('dashboard');
        Route::delete('/delete',[MemberController::class,'delete'])->name('delete');
    });

    Route::prefix('/complementary')->group(function () {
        Route::get('/getProvince',[ComplimentaryController::class,'getProvince'])->name('getProvince');
        Route::get('/getDistrict',[ComplimentaryController::class,'getDistrict'])->name('getDistrict');
        Route::get('/getSubDistrict',[ComplimentaryController::class,'getSubDistrict'])->name('getSubDistrict');
        Route::get('/getVillage',[ComplimentaryController::class,'getVillage'])->name('getVillage');
        Route::get('/getDashoardData',[ComplimentaryController::class,'getCountDashboard'])->name('getDashoardData');
    });

    Route::prefix('/category-news')->name('category-news.')->group(function () {
        Route::get('/',[CategoryNewsController::class,'index'])->name('index');
        Route::post('/store',[CategoryNewsController::class,'store'])->name('store');
        Route::put('/update',[CategoryNewsController::class,'update'])->name('update');
        Route::get('/datatables',[CategoryNewsController::class,'datatables'])->name('datatables');
        Route::get('/detail/{id}',[CategoryNewsController::class, 'detail'])->name('detail');
        Route::delete('/delete',[CategoryNewsController::class,'delete'])->name('delete');
        Route::get('/search/{slug}',[CategoryNewsController::class,'search'])->name('search');
    });

    Route::prefix('/category-events')->name('category-events.')->group(function () {
        Route::get('/',[CategoryEventController::class,'index'])->name('index');
        Route::post('/store',[CategoryEventController::class,'store'])->name('store');
        Route::put('/update',[CategoryEventController::class,'update'])->name('update');
        Route::get('/datatables',[CategoryEventController::class,'datatables'])->name('datatables');
        Route::get('/detail/{id}',[CategoryEventController::class, 'detail'])->name('detail');
        Route::delete('/delete',[CategoryEventController::class,'delete'])->name('delete');
        Route::get('/search/{slug}',[CategoryEventController::class,'search'])->name('search');
    });

    Route::prefix('/news')->name('news.')->group(function () {
        Route::get('/index/{type}',[NewsController::class,'index'])->name('index');
        Route::get('/create-update/{type}',[NewsController::class,'createUpdate'])->name('create-update');
        Route::post('/store',[NewsController::class,'store'])->name('store');
        Route::put('/update',[NewsController::class,'update'])->name('update');
        Route::get('/datatables',[NewsController::class,'datatables'])->name('datatables');
        Route::get('/detail/{id}',[NewsController::class, 'detail'])->name('detail');
        Route::get('/read/{category}/{id}/{slug}',[NewsController::class, 'read'])->name('read');
        Route::delete('/delete',[NewsController::class,'delete'])->name('delete');
        Route::put('/recover',[NewsController::class,'recover'])->name('recover');
        Route::get('/search/{slug}',[NewsController::class,'search'])->name('search');
    });

    Route::prefix('/events')->name('events.')->group(function () {
        Route::get('/index',[EventController::class,'index'])->name('index');
        Route::get('/create',[EventController::class,'create'])->name('create');
        Route::post('/store',[EventController::class,'store'])->name('store');
        Route::put('/update',[EventController::class,'update'])->name('update');
        Route::get('/datatables',[EventController::class,'datatables'])->name('datatables');
        Route::get('/detail/{id}',[EventController::class, 'detail'])->name('detail');
        Route::get('/read/{category}/{id}/{slug}',[EventController::class, 'read'])->name('read');
        Route::delete('/delete',[EventController::class,'delete'])->name('delete');
        Route::put('/recover',[EventController::class,'recover'])->name('recover');
        Route::get('/search/{slug}',[EventController::class,'search'])->name('search');
    });
});

Route::prefix('pwa')->name('pwa.')->group(function () {
    Route::get('/otp/{email}',[PWAController::class,'otp'])->name('otp');
    Route::get('/',[PWAController::class,'index'])->name('index');
    Route::middleware(['auth.pwa'])->group(function () {
        Route::get('/register/{id}',[PWAController::class,'register'])->name('register');
        Route::get('/profile/{email}',[PWAController::class,'profile'])->name('profile');
        Route::get('/update/{id}',[PWAController::class,'update'])->name('update');
        Route::put('/store_update',[PWAController::class,'store_update'])->name('store_update');
        Route::get('/download_kta/{id}',[PWAController::class,'download_kta'])->name('download_kta');
    });
    Route::post('/logout',[PWAController::class,'logout'])->name('logout');
});


Route::get('/privacy-policy', function (Request $request) {
    return view('policy');
});
