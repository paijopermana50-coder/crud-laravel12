<?php

use App\Http\Controllers\MobilController;
use Illuminate\Support\Facades\Route;

Route::resource('/mobil', MobilController::class);

Route::get('/', function () {
    return view('welcome');
});
