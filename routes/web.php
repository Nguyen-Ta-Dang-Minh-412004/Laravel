<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('trangchu');
});
Route::get('/doanhthu', function () {
    return view('doanhthu');
});
