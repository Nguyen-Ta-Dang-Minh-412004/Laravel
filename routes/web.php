<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('Laravel');
});
Route::get('/doanhthu', function () {
    return view('Doanhthu');
});
