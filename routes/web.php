<?php

use DeParis\Kernel\Routing\Route;

return [
    Route::get('/', ['FriendController::class', 'index'])
];