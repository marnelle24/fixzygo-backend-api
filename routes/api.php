<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\ContactController;
use App\Http\Controllers\Api\v1\CategoryController;
use App\Http\Controllers\Api\v1\AuthController;

Route::get('/ping', function () {
    return response()->json(['message' => 'API is working']);
});

Route::prefix('v1')->group(function () {
    Route::post('register', [AuthController::class, 'register'])->name('api.v1.register');
    Route::post('login', [AuthController::class, 'login'])->name('api.v1.login');

    Route::get('categories', [CategoryController::class, 'index'])->name('api.v1.categories');

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

        //  Category API
        Route::get('category/{category}', [CategoryController::class, 'show'])->name('api.v1.category');
        Route::post('category', [CategoryController::class, 'store'])->name('api.v1.save.category');
        Route::put('category', [CategoryController::class, 'update'])->name('api.v1.update.category');
        Route::delete('category/{category}', [CategoryController::class, 'destroy'])->name('api.v1.delete.category');

        // Admin Routes
        Route::middleware('role:admin')->group(function () {
            Route::get('/admin/dashboard', function() {
                return response()->json(['message' => 'this is admin dashboard']);
            })->name('api.v1.admin.dashboard');
        });

        // User Routes
        Route::middleware('role:user')->group(function () {
            Route::get('/user/dashboard', function() {
                return response()->json(['message' => 'this is user dashboard']);
            })->name('api.v1.user.dashboard');
        });

    });
});
