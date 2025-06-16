<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

// หน้าแรก (ไม่ต้องล็อกอิน)
Route::get('/', function () {
    return view('dashboard');
});

// กลุ่ม Route ที่ต้องล็อกอิน
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // ฟอร์มค้นหาเที่ยวบิน
    Route::get('/booking', [ApiController::class, 'bookingForm'])->name('booking');

    // ผลการค้นหาเที่ยวบิน
    Route::get('/search-flights', [ApiController::class, 'searchFlights'])->name('search');

    // รายละเอียดการจอง
    Route::get('/booking-details', [ApiController::class, 'showBookingDetails'])->name('booking-details');

    // ยืนยันการจอง
    Route::post('/confirm-booking', [ApiController::class, 'confirmBooking'])->name('confirm-booking');

    // แสดงหน้าสำเร็จ
    Route::get('/booking-confirmation', function () {
        return view('booking-confirmation');
    })->name('booking-confirmation');

    // ประวัติการจอง
    Route::get('/booking-history', [ApiController::class, 'bookingHistory'])->name('booking-history');

    // แสดงตั๋ว
    Route::get('/booking/{id}/ticket', [ApiController::class, 'showTicket'])->name('booking.ticket');

});
