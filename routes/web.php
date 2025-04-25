<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');
Route::get('/order', function () {
    return view('order');
})->name('order');
Route::get('/history', function () {
    return view('history');
})->name('history');
