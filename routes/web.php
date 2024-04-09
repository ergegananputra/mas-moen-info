<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SummernoteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', [ArticleController::class, 'index'])->name('article.index');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/photos/upload', [SummernoteController::class, 'upload'])->name('summernote.upload');

    Route::middleware('admin')->group(function () {
        Route::get('/artikel/create', [ArticleController::class, 'create'])->name('article.create');
        Route::post('/artikel', [ArticleController::class, 'store'])->name('article.store');
        Route::get('/artikel/{article_seo}/edit', [ArticleController::class, 'edit'])->name('article.edit');
        Route::post('/artikel/{article_seo}/edit/photos/{id}/delete', [ArticleController::class, 'deletePhoto'])->name('article.deletePhoto');
        Route::post('/artikel/{article_seo}/update', [ArticleController::class, 'update'])->name('article.update');
        Route::delete('/artikel/delete/{id}', [ArticleController::class, 'destroy'])->name('article.destroy');
    });
});


Route::get('/artikel', [ArticleController::class, 'index'])->name('article.index');
Route::get('/artikel/search', [ArticleController::class, 'search'])->name('article.search');
Route::get('/artikel/{article_seo}', [ArticleController::class, 'show'])->name('article.show');
Route::get('/artikel/{category}', [ArticleController::class, 'indexByCategory'])->name('article.category');
Route::get('/dashboard', [ArticleController::class, 'index'])->name('article.index');

require __DIR__.'/auth.php';
