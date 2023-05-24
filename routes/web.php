<?php

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


Route::prefix('/booking')->group(function () {
    Route::get('/', [BookingController::class, 'bookingField'])->name('BookingField');
    Route::get('/{path}', [BookingController::class, 'bookingTime'])->name('BookingTime');
    Route::post('/request', [BookingController::class, 'timeRequest'])->name('timeRequest');
    Route::post('/save', [BookingController::class, 'store'])->name('StoreBooking');
    Route::get('/{booking}/check', [BookingController::class, 'detailBooking'])->name('checkBooking');
});
