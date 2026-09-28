<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\FileManagerController;
use App\Http\Controllers\AccountManagerController;
use App\Http\Controllers\CloudProviderController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Home / Welcome Page
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

/*
|--------------------------------------------------------------------------
| OAuth Routes (Google Authentication)
|--------------------------------------------------------------------------
*/
Route::get('/auth/google', [CloudProviderController::class, 'redirectToGoogle'])
    ->name('auth.google');

Route::get('/auth/google/callback', [CloudProviderController::class, 'handleGoogleCallback']);

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [FileManagerController::class, 'index'])->name('dashboard');

    // Account Management
    Route::get('/accounts', [AccountManagerController::class, 'index'])->name('accounts.manage');
    Route::post('/accounts/update', [AccountManagerController::class, 'updateCombined'])->name('accounts.update');
    Route::delete('/accounts/{id}', [AccountManagerController::class, 'removeAccount'])->name('accounts.remove');

    // File Management
    Route::post('/upload', [FileManagerController::class, 'upload'])->name('files.upload');
    Route::get('/download/{fileId}/{fileName}/{mimeType?}', [FileManagerController::class, 'download'])->name('files.download');
    Route::delete('/delete/{fileId}', [FileManagerController::class, 'delete'])->name('files.delete');
    Route::post('/folder', [FileManagerController::class, 'createFolder'])->name('folders.create');

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Authentication Routes (Laravel Breeze)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';
