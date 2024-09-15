<?php

use App\Http\Controllers\AddMovementController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MovementsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
Route::get('/', function () {
    return view('welcome');
});
*/

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/dashboard', [HomeController::class, 'show'])->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', [HomeController::class, 'show'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/dashboard/resoconto', [HomeController::class, 'getResoconto'])->middleware(['auth', 'verified']);
Route::get('/dashboard/graph', [HomeController::class, 'getGraphValues'])->middleware(['auth', 'verified']);
Route::get('/dashboard/statistics', [HomeController::class, 'getStatistics'])->middleware(['auth', 'verified']);

Route::get('/categories', [CategoriesController::class, 'show'])->middleware(['auth', 'verified'])->name('categories');
Route::post('/categories', [CategoriesController::class, 'saveCategory'])->middleware(['auth', 'verified']);
Route::delete('/categories', [CategoriesController::class, 'deleteCategory'])->middleware(['auth', 'verified']);



// Modificare
Route::get('/aggiungi', [AddMovementController::class, 'show'])->middleware(['auth', 'verified'])->name('aggiungi');
Route::post('/aggiungi', [AddMovementController::class, 'add'])->middleware(['auth', 'verified'])->name('aggiungi');

Route::get('/movimenti', [MovementsController::class, 'show'])->middleware(['auth', 'verified'])->name('movimenti');

Route::get('/movimenti/detail/{id}', [MovementsController::class, 'detail'])->middleware(['auth', 'verified'])->name('movimenti_detail');
Route::post('/movimenti/detail/{id}', [MovementsController::class, 'update'])->middleware(['auth', 'verified'])->name('movimenti_detail');

Route::get('/movimenti_list', [MovementsController::class, 'show_list'])->middleware(['auth', 'verified'])->name('movimenti_list');

Route::get('/common/categories_by/movement_type_id', [CommonController::class, 'getCategoriesByMovementType'])->middleware(['auth', 'verified']);

Route::get('/esporta', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('esporta');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
