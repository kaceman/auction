<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [ArticleController::class, 'index'])->name('home');
Route::get('/articles/show/{article}', [ArticleController::class, 'show'])->name('article.show');

Route::middleware('auth')->group(function () {
    // profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // article
    Route::get('/articles', [ArticleController::class, 'myArticles'])->name('article.mine');
    Route::get('/articles/create', [ArticleController::class, 'create'])->name('article.create');
    Route::get('/articles/{article}', [ArticleController::class, 'edit'])->name('article.edit');
    Route::post('/articles/{article}', [ArticleController::class, 'update'])->name('article.update');
    Route::post('/articles', [ArticleController::class, 'store'])->name('article.store');
    Route::post('/articles/bid', [ArticleController::class, 'bid'])->name('article.bid');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin');
    Route::get('/admin/articles', [AdminController::class, 'articles'])->name('admin.articles');
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/admin/articles/{article}', [AdminController::class, 'show'])->name('admin.show');
    Route::post('/admin/articles/status/{article}', [AdminController::class, 'toogleStatus'])->name('admin.status');
});

require __DIR__.'/auth.php';
