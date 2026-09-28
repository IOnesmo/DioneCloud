<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\FileManagerController;
use App\Http\Controllers\AccountManagerController;
use App\Http\Controllers\CloudProviderController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

// OAuth routes
Route::get('/auth/google', [CloudProviderController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [CloudProviderController::class, 'handleGoogleCallback']);

// Authenticated routes - NO verified middleware!
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [FileManagerController::class, 'index'])->name('dashboard');

    Route::get('/accounts', [AccountManagerController::class, 'index'])->name('accounts.manage');
    Route::post('/accounts/update', [AccountManagerController::class, 'updateCombined'])->name('accounts.update');
    Route::delete('/accounts/{id}', [AccountManagerController::class, 'removeAccount'])->name('accounts.remove');


    // File Actions
    Route::post('/upload', [FileManagerController::class, 'upload'])->name('files.upload');
    Route::get('/download/{fileId}/{fileName}/{mimeType?}', [FileManagerController::class, 'download'])->name('files.download');
    Route::get('/view/{fileId}/{fileName}/{mimeType?}', [FileManagerController::class, 'view'])->name('files.view');
    Route::get('/edit/{fileId}/{fileName}/{mimeType?}', [FileManagerController::class, 'edit'])->name('files.edit');
    Route::get('/print/{fileId}/{fileName}/{mimeType?}', [FileManagerController::class, 'print'])->name('files.print');
    Route::delete('/delete/{fileId}', [FileManagerController::class, 'delete'])->name('files.delete');
    Route::post('/folder', [FileManagerController::class, 'createFolder'])->name('folders.create');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');






});

require __DIR__.'/auth.php';
