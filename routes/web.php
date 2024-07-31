<?php

use App\Http\Controllers\EventsController;
use App\Http\Controllers\UserController;
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
        return view('dashboard.dashboard');
    });

    Route::get('/users',[UserController::class,'index'])->name('users.users');
    Route::get('/user_details/{id}',[UserController::class,'getUserDetails']);
    Route::post('/users/block/{id}', [UserController::class, 'blockUser']);
    Route::post('/users', [UserController::class, 'userSearch']);
    Route::resource('events', EventsController::class);
    //Route::get('/events/show/{id}', [EventsController::class, 'show']);