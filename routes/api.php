<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AvailableCarsController;

Route::middleware('auth.basic')->get('/available-cars', [AvailableCarsController::class, 'index']);
