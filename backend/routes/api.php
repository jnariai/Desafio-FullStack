<?php

use App\Http\Controllers\DesenvolvedorController;
use App\Http\Controllers\NivelController;
use App\Http\Controllers\SelectNivelController;
use Illuminate\Support\Facades\Route;

Route::apiResource('desenvolvedor', DesenvolvedorController::class);
Route::apiResource('nivel', NivelController::class);
Route::get('select/nivel', SelectNivelController::class);
