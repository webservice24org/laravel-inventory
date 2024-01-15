<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Sanctum;

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

//Web Api for Users
Route::post('/register', [UserController::class, 'userRegistration']);
Route::post('/login', [UserController::class, 'UserLogin'])->name('user.login');
Route::get('/user-profile', [UserController::class, 'UserProfile'])->middleware('auth:sanctum');
Route::get('/logout', [UserController::class, 'UserLogout'])->name('logout')->middleware('auth:sanctum');
Route::post('/user-profile-update', [UserController::class, 'userProfileUpdate'])->middleware('auth:sanctum');
Route::post('/send-otp', [UserController::class, 'sendOtpCode']);
Route::post('/verify-otp', [UserController::class, 'VerifyOtp']);
Route::post('/reset-password', [UserController::class, 'resetPassword'])->middleware('auth:sanctum');


//Web Api Routes for Categories

Route::post('/create-category', [CategoryController::class, 'createCategory'])->middleware('auth:sanctum');
Route::get('/category-list', [CategoryController::class, 'categoryList'])->middleware('auth:sanctum');
Route::post('/category-update', [CategoryController::class, 'updateCategory'])->middleware('auth:sanctum');
Route::post('/delete-category', [CategoryController::class,'deleteCategory'])->middleware('auth:sanctum');
Route::get('/category-by-id', [CategoryController::class,'CategoryById'])->middleware('auth:sanctum');


//view pages
Route::view('/login', 'pages.auth.login-page')->name('login');
Route::view('/userProfile', 'pages.dashboard.profile-page');
Route::view('/register', 'pages.auth.registration-page')->name('register');
Route::view('/send-otp', 'pages.auth.otp-page')->name('otp');
Route::view('/verify-otp', 'pages.auth.verify-otp-page');
Route::view('/reset-password', 'pages.auth.reset-password-page');

Route::view('/category-page', 'pages.dashboard.category-page')->name('category');