<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

Route::get('/', function () {
    return view('home');
});
Route::get('/booking', [ApiController::class, 'bookingForm']);
Route::get('/search-flights', [ApiController::class, 'searchFlights']);
