<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\InterestController;

//  Interest API
Route::get('interests', [InterestController::class, 'index'])->name('api.v1.interests');
Route::post('interest', [InterestController::class, 'store'])->name('api.v1.save.interest');
Route::get('interest/{interest}', [InterestController::class, 'show'])->name('api.v1.interest');
Route::put('interest/{interest}', [InterestController::class, 'update'])->name('api.v1.update.interest');
Route::delete('interest/{interest}', [InterestController::class, 'destroy'])->name('api.v1.delete.interest');

// get interests by user
Route::get('user/all-interests', [InterestController::class, 'getUserInterests'])->name('api.v1.user.interests');
// get user interest
Route::get('user/interest/{interest}', [InterestController::class, 'getUserInterest'])->name('api.v1.user.interest');
// update user interest
Route::put('user/interest/{interest}', [InterestController::class, 'updateUserInterest'])->name('api.v1.user.update.interest');
// Delete user interest
Route::delete('user/interest/{interest}', [InterestController::class, 'deleteUserInterest'])->name('api.v1.user.delete.interest');
