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

Route::get('/test-wablas', function () {
    $token = "GGeaF8RXvcZO5fllnKD4OhN23Rns7B5Q2xHOg14nxoK52MjI8onb0ON";       // Ganti dengan token kamu
    $secret_key = "ecsfSwIZ"; // Ganti dengan secret key kamu

    // Message details
    $phone = "081336920647"; // Ganti dengan nomor tujuan
    $message = "Hello! This is a test message from Wablas API. setelah di restart";

    // URL encode the message
    $message_encoded = urlencode($message);

    // Build API URL
    $api_url = "https://sby.wablas.com/api/send-message?token={$token}.{$secret_key}&phone={$phone}&message={$message_encoded}";

    // Initialize cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); // Nonaktifkan SSL verify untuk testing
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

    // Execute request
    $response = curl_exec($ch);

    // Check for errors
    if (curl_errno($ch)) {
        echo "cURL Error: " . curl_error($ch);
    } else {
        echo "<pre>";
        print_r(json_decode($response, true)); // Decode JSON supaya lebih readable
        echo "</pre>";
    }

    // Close cURL session
    return response()->json($response);
});

Route::get('/storage-link', function () {
    $target = storage_path('app/public');
    $link = public_path('storage');

    if (!File::exists($link)) {
        File::makeDirectory($link, 0755, true);
    }

    File::copyDirectory($target, $link);

    return 'Storage files copied to public/storage!';
});

Route::get('/run-seeder', function () {
    try {
        Artisan::call('db:seed', [
            '--class' => 'DatabaseSeeder', // atau seeder spesifik
            '--force' => true, // penting untuk production agar bisa jalan
        ]);

        return '<h3>✅ Seeder berhasil dijalankan!</h3>';
    } catch (\Exception $e) {
        return '<h3>❌ Gagal menjalankan seeder:</h3><pre>' . $e->getMessage() . '</pre>';
    }
});

Route::get('/run-schedule', function () {
    Artisan::call('schedule:run');
    return 'Scheduler executed at ' . now();
});

Route::get('/run-reminder', function () {
    Artisan::call('reminder:send');
    return 'Reminder executed at ' . now();
});

use App\Http\Controllers\CheckerFrontendController;

Route::prefix('komfychecker')->name('checker.')->group(function () {
    Route::get('/', [CheckerFrontendController::class, 'landing'])->name('landing');
    Route::get('/form/{slug}', [CheckerFrontendController::class, 'form'])->name('form');
    Route::get('/checkout/{invoice}', [CheckerFrontendController::class, 'checkout'])->name('checkout');
    Route::get('/track', [CheckerFrontendController::class, 'track'])->name('track');
    Route::get('/track/{invoice}', [CheckerFrontendController::class, 'trackDetail'])->name('track.detail');
    Route::get('/payment-order/{invoice}', [CheckerFrontendController::class, 'payment'])->name('payment');
});

require __DIR__ . '/auth.php';
