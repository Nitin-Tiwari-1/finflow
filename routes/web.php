<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomAuthController;

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


Route::get('login', [CustomAuthController::class, 'index'])->name('login')->middleware('guest');
Route::post('custom-login', [CustomAuthController::class, 'customLogin'])->name('login.custom')->middleware('guest');
Route::get('registration', [CustomAuthController::class, 'registration'])->name('register-user')->middleware('guest');
Route::post('custom-registration', [CustomAuthController::class, 'customRegistration'])->name('register.custom')->middleware('guest');

Route::middleware('auth')->group(function () {
    Route::get('dashboard', [CustomAuthController::class, 'dashboard'])->name('dashboard'); 
    Route::get('signout', [CustomAuthController::class, 'signOut'])->name('signout');
    Route::get('profile/edit', [CustomAuthController::class, 'editProfile'])->name('profile.edit');
    Route::post('profile/update', [CustomAuthController::class, 'updateProfile'])->name('profile.update');
    Route::get('profile/change-password', [CustomAuthController::class, 'showChangePasswordForm'])->name('profile.change-password');
    Route::post('profile/change-password', [CustomAuthController::class, 'changePassword'])->name('profile.change-password.post');
});
