<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PetController;
use App\Http\Controllers\VisitController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('pets', PetController::class);

Route::resource('visits', VisitController::class);