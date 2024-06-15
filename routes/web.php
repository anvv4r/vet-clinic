<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PetController;
use App\Http\Controllers\VisitController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('pets', PetController::class);

Route::get('visits/create/{owner_id}/{pet_id}', [VisitController::class, 'create'])->name('visits.create');
Route::resource('visits', VisitController::class)->except('create');

Route::get('visits/edit/{owner_id}/{pet_id}', [VisitController::class, 'edit'])->name('visits.edit');