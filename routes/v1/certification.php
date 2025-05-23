<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\CertificationController;

//  Certification API
Route::get('certifications', [CertificationController::class, 'index'])->name('api.v1.certifications');
Route::get('certification/{certification}', [CertificationController::class, 'show'])->name('api.v1.certification');
Route::post('certification', [CertificationController::class, 'store'])->name('api.v1.save.certification');
Route::put('certification/{certification}', [CertificationController::class, 'update'])->name('api.v1.update.certification');
Route::delete('certification/{certification}', [CertificationController::class, 'destroy'])->name('api.v1.delete.certification');

// get certifications by user
Route::get('user/{certification}', [CertificationController::class, 'getUserCertifications'])->name('api.v1.user.certifications');
// get user certification
Route::get('user/certification/{certification}', [CertificationController::class, 'getUserCertification'])->name('api.v1.user.certification');
// update user certification
Route::put('user/certification/{certification}', [CertificationController::class, 'updateUserCertification'])->name('api.v1.user.update.certification');
