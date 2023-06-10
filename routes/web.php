<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('user-login',[AuthController::class,'customLogin'])->name('customLogin')->middleware('alreadyLogin');
Route::post('user-login-post',[AuthController::class,'loginUser'])->name('customloginUser');
Route::get('user-registration',[AuthController::class,'customRegistration'])->name('customRegistration')->middleware('alreadyLogin');
Route::post('user-registration-post',[AuthController::class,'registrationSave'])->name('customregistrationSave');
Route::get('custom-dashboard',[AuthController::class,'dashboard'])->name('customDashboard')->middleware('isLoggedIn');
Route::get('admin-dashboard',[AuthController::class,'adminDashboard'])->name('adminDashboard')->middleware('isLoggedIn');
Route::get('custom-logout',[AuthController::class,'customLogout'])->name('customLogout');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
