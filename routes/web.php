<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ProfileController;
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
Route::get('/artikel', [ArticleController::class, 'index'])->name('article.index');
Route::get('/artikel/{id}/{article_seo}', [ArticleController::class, 'show'])->name('article.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('admin')->group(function () {
        Route::get('/artikel/create', [ArticleController::class, 'create'])->name('article.create');
        Route::post('/artikel', [ArticleController::class, 'store'])->name('article.store');
    });
});

require __DIR__.'/auth.php';
