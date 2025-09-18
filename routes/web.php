<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LinkGeneratorController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\VoterController;
use App\Http\Controllers\VotingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [VotingController::class, 'index'])->name('voting.index');
Route::post('/vote', [VotingController::class, 'vote'])->name('voting.store');
Route::post('/check-nik', [VotingController::class, 'checkNik'])->name('voting.checkNik');
Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/link-generator', [LinkGeneratorController::class, 'index'])->name('linkGenerator.index');
    // Kalau orang buka /admin, langsung arahin ke daftar produk
    Route::get('/', function () {
        return redirect()->route('admin.products.index');
    });
    Route::get('/vote', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);

    Route::get('/voters/export', [VoterController::class, 'export'])->name('voters.export');
    Route::get('/voters', [VoterController::class, 'index'])->name('voters.index');
    Route::get('/voters/{voter}', [VoterController::class, 'show'])->name('voters.show');
});
