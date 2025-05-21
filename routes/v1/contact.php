<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\ContactController;

Route::get('contacts', [ContactController::class, 'index'])->name('api.v1.user.contacts');
Route::get('contact/{contact}', [ContactController::class, 'show'])->name('api.v1.contact');
Route::post('contact', [ContactController::class, 'store'])->name('api.v1.save.contact');
Route::put('contact/{contact}', [ContactController::class, 'update'])->name('api.v1.update.contact');
Route::delete('contact/{contact}', [ContactController::class, 'destroy'])->name('api.v1.delete.contact');