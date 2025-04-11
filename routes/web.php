<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');
Route::get('/order-list', function () {
    return view('order-list');
})->name('order.list');
