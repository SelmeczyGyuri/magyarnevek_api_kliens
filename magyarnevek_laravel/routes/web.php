<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NameController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\StatController;

Route::get('/', function () {
    return redirect()->route('names.index');
});

Route::get('/names', [NameController::class, 'index'])->name('names.index');
Route::get('/names/{name}', [NameController::class, 'show'])->name('names.show');

Route::get('/search', [SearchController::class, 'index'])->name('search.index');

Route::get('/stats', [StatController::class, 'index'])->name('stats.index');