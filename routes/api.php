<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\CategoryController;
use App\Http\Controllers\Api\v1\AuthController;

Route::get('/ping', function () {
    return response()->json(['message' => 'API is working']);
});

Route::prefix('v1')->group(function () {

    // Public API Routes
    Route::post('register', [AuthController::class, 'register'])->name('api.v1.register');
    Route::post('login', [AuthController::class, 'login'])->name('api.v1.login');
    Route::get('categories', [CategoryController::class, 'index'])->name('api.v1.categories');

    // Protected API Routes
    Route::middleware('auth:sanctum')->group(function () {
        
        Route::post('logout', [AuthController::class, 'logout'])->name('api.v1.logout');
        Route::get('user', [AuthController::class, 'me'])->name('api.v1.profile');
        Route::delete('user/{user}', [AuthController::class, 'destroy'])->name('api.v1.delete.user');

        //  Education API Routes
        require base_path('routes/v1/education.php');

        //  Contact API Routes
        require base_path('routes/v1/contact.php');

        //  Category API Routes
        require base_path('routes/v1/category.php');

        // Certification API Routes
        require base_path('routes/v1/certification.php');

        // Accomplishment API Routes
        require base_path('routes/v1/accomplishment.php');

        // Interest API Routes
        require base_path('routes/v1/interest.php');

        // Review API Routes
        require base_path('routes/v1/review.php');

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
