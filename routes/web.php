<?php

use Illuminate\Support\Facades\Route;

require_once __DIR__ . '/user.php';
require_once __DIR__ . '/admin.php';

Route::get('/example', function () {
    return 'Hello World';
});
