<?php

use Illuminate\Support\Facades\Route;
use App\Infrastructure\Http\Controllers\TorneoController;

Route::post('/torneos/simular', [TorneoController::class, 'simular']);
