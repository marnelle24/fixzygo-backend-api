<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\AuthController;

Route::get('/ping', function () {
    return response()->json(['message' => 'API is working']);
});

Route::prefix('v1')->group(function () {
    Route::post('register', [AuthController::class, 'register'])->name('api.v1.register');
    Route::post('login', [AuthController::class, 'login'])->name('api.v1.login');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AuthController::class, 'logout'])->name('api.v1.logout');
        Route::get('user', [AuthController::class, 'me'])->name('api.v1.profile');
    });
});
