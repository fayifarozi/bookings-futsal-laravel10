<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ScheduleController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('home');
});

Route::get('/login',[AuthController::class, 'index'])->name('login');
Route::post('/login',[AuthController::class, 'login']);
Route::post('/logout',[AuthController::class, 'logout'])->name('logout');

Route::prefix('/booking')->group(function () {
    Route::get('/captcha', [BookingController::class, 'reloadCaptcha'])->name('reloadCaptcha');
    Route::get('/', [BookingController::class, 'bookingField'])->name('BookingField');
    Route::get('/coba/1', [BookingController::class, 'bookingFieldEX'])->name('BookingFieldCOBA');
    Route::get('/{path}', [BookingController::class, 'bookingTime'])->name('BookingTime');
    Route::post('/request', [BookingController::class, 'timeRequest'])->name('timeRequest');
    Route::post('/save', [BookingController::class, 'store'])->name('StoreBooking');
    Route::get('/{booking}/check', [BookingController::class, 'detailBooking'])->name('checkBooking');
});

Route::middleware(['admin'])->group(function () {
    Route::prefix('/master')->group(function () {
        Route::get('/', [DashboardController::class, 'getInfoBooking'])->name('dasboard');
        Route::get('/mount-chart', [DashboardController::class, 'getFilterByMounts'])->name('dasboard.grupby-mounts');
        
        Route::get('/admin', [UserController::class, 'getAllAdmin'])->name('admin');
        Route::get('/admin/create', [UserController::class, 'create'])->name('admin.create');
        Route::post('/admin/save', [UserController::class, 'store'])->name('admin.save');
        Route::get('/admin/{user}/edit', [UserController::class, 'edit'])->name('admin.edit');
        Route::match(['patch', 'put'],'/admin/{user}/update', [UserController::class, 'update'])->name('admin.update');
        Route::delete('/admin/{user}/delete', [UserController::class, 'destroy'])->name('admin.delete');
        
        Route::get('/bookings', [BookingController::class, 'getAllBooking'])->name('bookings');
        Route::get('/bookings/{booking}/check', [BookingController::class, 'detailBookingMaster'])->name('detail.bookings');
    
        Route::get('/futsal-field', [FieldController::class, 'getAllField'])->name('fields');
        Route::get('/futsal-field/create', [FieldController::class, 'createField'])->name('fields.create');
        Route::post('/futsal-field/save', [FieldController::class, 'store'])->name('fields.save');
        Route::get('/futsal-field/{path}/edit', [FieldController::class, 'editField'])->name('fields.edit');
        Route::post('/futsal-field/update', [FieldController::class, 'updateField'])->name('fields.update');
        Route::post('/futsal-field/update-status', [FieldController::class, 'updateStatus'])->name('fields.updateStatus');
        // Route::delete('/futsal-field/{id}/delete', [FieldController::class, 'destroyField'])->name('fields.delete');
    
        Route::get('/schedules', [ScheduleController::class, 'getAllSchedule'])->name('schedules');
        Route::post('/schedules/open-hour', [ScheduleController::class, 'addScheduleOpen'])->name('schedules.setOpenTime');
        Route::post('/schedules/update', [ScheduleController::class, 'updateStatus'])->name('schedules.updateOpenTime');
        Route::get('/payments', [PaymentController::class, 'getAllPayment'])->name('payments');
    });
}); 

