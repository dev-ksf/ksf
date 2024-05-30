<?php

use Illuminate\Support\Facades\Route;

Route::get('{any?}', function () {
    return view('application');
})->where('any', '.*');

// Route::get('/test', function () {
//     return 'test';
// });
