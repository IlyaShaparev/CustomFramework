<?php

use App\Controllers\CarController;
use App\Controllers\HomeController;
use DeParis\Kernel\Routing\Route;

return [
    Route::get('/', [HomeController::class, 'index']),
    Route::get('/cars/{name}', [CarController::class, 'show']),
];