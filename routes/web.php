<?php

use App\Http\Controllers\UserController;
use app\Http\Controllers\Auth\LoginController;
use app\Http\Controllers\Auth\RegisterController;
use app\Http\Controllers\RoleController;
use app\Http\Controllers\PermissionController;
use App\Http\Controllers\SettingController;
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

Route::get('/', function () {
    return redirect()->route('home');
});

Auth::routes(['verify'=>true]);


Route::group(['middleware' => ['auth','verified']], function () {

    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/components', function(){
        return view('components');
    })->name('components');


    Route::resource('users', 'UserController');

    Route::get('/profile/{user}', [UserController::class,'profile'])->name('profile.edit');

    Route::post('/profile/{user}', [UserController::class,'profileupdate'])->name('profile.update');

    Route::resource('roles', 'RoleController')->except('show');

    Route::resource('permissions', 'PermissionController')->except(['show','destroy','update']);

    Route::resource('category', 'CategoryController')->except('show');

    Route::resource('post', 'PostController');

    Route::get('/activity-log', [SettingController::class,'activity'])->name('activity-log.index');

    Route::get('/settings', [SettingController::class,'index'])->name('settings.index');

    Route::post('/settings', [SettingController::class,'update'])->name('settings.update');


    Route::get('media', function (){
        return view('media.index');
    })->name('media.index');
});
