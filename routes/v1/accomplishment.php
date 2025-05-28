<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\AccomplishmentController;

//  Accomplishment API
Route::get('accomplishments', [AccomplishmentController::class, 'index'])->name('api.v1.accomplishments');
Route::post('accomplishment', [AccomplishmentController::class, 'store'])->name('api.v1.save.accomplishment');
Route::get('accomplishment/{accomplishment}', [AccomplishmentController::class, 'show'])->name('api.v1.accomplishment');
Route::put('accomplishment/{accomplishment}', [AccomplishmentController::class, 'update'])->name('api.v1.update.accomplishment');
Route::delete('accomplishment/{accomplishment}', [AccomplishmentController::class, 'destroy'])->name('api.v1.delete.accomplishment');

// get accomplishments by user
Route::get('user/all-accomplishments', [AccomplishmentController::class, 'getUserAccomplishments'])->name('api.v1.user.accomplishments');
// get user accomplishment
Route::get('user/accomplishment/{accomplishment}', [AccomplishmentController::class, 'getUserAccomplishment'])->name('api.v1.user.accomplishment');
// update user accomplishment
Route::put('user/accomplishment/{accomplishment}', [AccomplishmentController::class, 'updateUserAccomplishment'])->name('api.v1.user.update.accomplishment');
// Delete user accomplishment
Route::delete('user/accomplishment/{accomplishment}', [AccomplishmentController::class, 'deleteUserAccomplishment'])->name('api.v1.user.delete.accomplishment');
