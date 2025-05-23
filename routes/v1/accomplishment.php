<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\AccomplishmentController;

//  Accomplishment API
Route::get('accomplishments', [AccomplishmentController::class, 'index'])->name('api.v1.accomplishments');
Route::post('accomplishment', [AccomplishmentController::class, 'store'])->name('api.v1.save.accomplishment');
// Route::get('certification/{certification}', [AccomplishmentController::class, 'show'])->name('api.v1.certification');
// Route::put('certification/{certification}', [AccomplishmentController::class, 'update'])->name('api.v1.update.certification');
// Route::delete('certification/{certification}', [AccomplishmentController::class, 'destroy'])->name('api.v1.delete.certification');

// get certifications by user
// Route::get('user/{certification}', [AccomplishmentController::class, 'getUserCertifications'])->name('api.v1.user.certifications');
// get user certification
// Route::get('user/certification/{certification}', [AccomplishmentController::class, 'getUserCertification'])->name('api.v1.user.certification');
// update user certification
// Route::put('user/certification/{certification}', [AccomplishmentController::class, 'updateUserCertification'])->name('api.v1.user.update.certification');
