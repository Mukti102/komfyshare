<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.home');
});


Route::resource('product', ProductController::class);
Route::resource('article', BlogController::class);
Route::resource('groups', GroupController::class);
Route::get('term', function () {
    return view('pages.term');
})->name('term');
Route::get('/payment-order/{invoice}', [PaymentController::class, 'index'])->name('payment.order');

// callback
Route::post('/tokopay/callback', [PaymentController::class, 'webhook'])->name('tokopay.webhook');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

use App\Http\Controllers\CheckerFrontendController;

Route::prefix('komfychecker')->name('checker.')->group(function () {
    Route::get('/', [CheckerFrontendController::class, 'landing'])->name('landing');
    Route::get('/form/{slug}', [CheckerFrontendController::class, 'form'])->name('form');
    Route::get('/paket/{id}/checkout', [CheckerFrontendController::class, 'packageCheckout'])->name('package.checkout');
    Route::get('/track/{invoice}', [CheckerFrontendController::class, 'trackDetail'])->name('track.detail');
    Route::get('/checkout/{invoice}', [CheckerFrontendController::class, 'checkout'])->name('checkout');
    Route::get('/paket/payment/{invoice}', [CheckerFrontendController::class, 'packagePayment'])->name('package.payment');
    Route::get('/track', [CheckerFrontendController::class, 'track'])->name('track');
    Route::get('/payment-order/{invoice}', [CheckerFrontendController::class, 'payment'])->name('payment');
});

require __DIR__ . '/auth.php';
