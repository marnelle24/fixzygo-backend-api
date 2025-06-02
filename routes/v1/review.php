<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\ReviewController;

Route::get('user/{user_id}/reviews', [ReviewController::class, 'index'])->name('api.v1.reviews');
Route::get('review/{review}', [ReviewController::class, 'show'])->name('api.v1.review');
Route::post('review', [ReviewController::class, 'store'])->name('api.v1.save.review');
Route::delete('user/{user_id}/review/{review}', [ReviewController::class, 'userRemoveReview'])->name('api.v1.user.delete.review');
Route::put('user/{user_id}/toggle-hide-review/{review}', [ReviewController::class, 'userShowHideReview'])->name('api.v1.toggleHide.review');