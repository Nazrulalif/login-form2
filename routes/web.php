<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
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
    if (Auth::check()){
        return redirect(route('welcome'));
        
    }
    return view('login');
});
Route::post('/',[AuthController::class,'loginPost'])->name('login.post'); 

Route::get('/registration',[AuthController::class,'registration'])->name('registration'); 
Route::post('/registration',[AuthController::class,'registrationPost'])->name('registration.post'); 

Route::get('/login',[AuthController::class,'index'])->name('login'); 
Route::post('/login',[AuthController::class,'loginPost'])->name('login.post'); 

Route::get('/logout',[AuthController::class,'logout'])->name('logout'); 

Route::group(['middleware'=>'auth'], function(){

    Route::get('/welcome', function () {
        return view('welcome');
    })->name('welcome');

    Route::get('/profile', function () {
        return view('profile');
    })->name('profile');
    
});



