<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
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
        Route::delete('user/{user}', [AuthController::class, 'destroy'])->name('api.v1.delete.user');
        
        // contacts API
        Route::get('contacts', [ContactController::class, 'index'])->name('api.v1.user.contacts');
        Route::get('contact/{contact}', [ContactController::class, 'show'])->name('api.v1.contact');
        Route::post('contact', [ContactController::class, 'store'])->name('api.v1.save.contact');
        Route::put('contact', [ContactController::class, 'update'])->name('api.v1.update.contact');
        Route::delete('contact/{contact}', [ContactController::class, 'destroy'])->name('api.v1.delete.contact');

    });
});
