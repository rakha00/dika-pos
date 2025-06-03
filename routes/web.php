<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReceiptController;
use Illuminate\Support\Facades\Route;

Route::get("/login", function () {
    return redirect("/admin/login");
})->name("login");

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/order', function () {
        return view('order');
    })->name('order');

    Route::get("/history", function () {
        return view("history");
    })->name("history");

    Route::get("/kitchen", function () {
        return view("kitchen");
    })->name("kitchen");

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
    Route::post('/profile/logout', [ProfileController::class, 'logout'])->name('profile.logout');

    Route::get('/receipt/print/{transactionId}', [ReceiptController::class, 'printReceipt'])->name('printReceipt');
});