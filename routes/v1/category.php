<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\CategoryController;

//  Category API
Route::get('category/{category}', [CategoryController::class, 'show'])->name('api.v1.category');
Route::post('category', [CategoryController::class, 'store'])->name('api.v1.save.category');
Route::put('category/{category}', [CategoryController::class, 'update'])->name('api.v1.update.category');
Route::delete('category/{category}', [CategoryController::class, 'destroy'])->name('api.v1.delete.category');

// Add category to user
Route::post('user/{userId}/category/{categoryId}', [CategoryController::class, 'addCategoryToUser'])->name('api.v1.user.category');
Route::delete('user/{userId}/category/{categoryId}', [CategoryController::class, 'removeCategoryFromUser'])->name('api.v1.user.category.remove');
