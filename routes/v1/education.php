<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\EducationController;

Route::get('educations', [EducationController::class, 'index'])->name('api.v1.educations');
Route::get('education/{education}', [EducationController::class, 'show'])->name('api.v1.education');
Route::post('education', [EducationController::class, 'store'])->name('api.v1.save.education');
Route::put('education/{education}', [EducationController::class, 'update'])->name('api.v1.update.education');
Route::get('user/educations', [EducationController::class, 'userEducations'])->name('api.v1.user.educations');
Route::get('user/education/{education}', [EducationController::class, 'userEducation'])->name('api.v1.user.education');
Route::put('user/education/{education}', [EducationController::class, 'userEducationUpdate'])->name('api.v1.user.update.education');
Route::delete('user/education/{education}', [EducationController::class, 'userEducationDestroy'])->name('api.v1.user.delete.education');