<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\FieldController;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



Route::get('/bookings', [BookingController::class, 'index'])->middleware('auth');
Route::post('/bookings', [BookingController::class, 'store'])->middleware('auth');



Route::get('/fields', [FieldController::class, 'index']);
