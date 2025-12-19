<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubmenuController;

// public route
Route::get('/', [HomeController::class, 'index']);
Route::get('/artikel/{article:slug}', [App\Http\Controllers\ArticleController::class, 'show'])->name('public.article.show');

// auth route
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// protected route
Route::middleware(['auth'])->group(function () {
    // admin route
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        // dashboard
        Route::get('/dashboard', function () {
            return view('dashboard.index');
        })->name('dashboard');

        // menu
        Route::resource('menu', MenuController::class)->names('menu');

        // submenu
        Route::resource('submenu', SubmenuController::class)->names('submenu');

        // slider
        Route::resource('slider', SliderController::class)->names('slider');

        // user
        Route::resource('user', UserController::class)->names('user');

        // profile
        Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

        // account settings
        Route::get('account', [ProfileController::class, 'editAccount'])->name('account.edit');
        Route::put('account', [ProfileController::class, 'updateAccount'])->name('account.update');

        // article
        Route::resource('article', App\Http\Controllers\ArticleController::class)->names('article');
        Route::post('article/upload-image', [App\Http\Controllers\ArticleController::class, 'uploadImage'])->name('article.uploadImage');


        // category
        Route::resource('category', App\Http\Controllers\CategoryController::class)->names('category');
    });

    // upt route
    Route::middleware(['role:upt'])->prefix('upt')->name('upt.')->group(function () {
        // dashboard
        Route::get('/dashboard', function () {
            return view('dashboard.index');
        })->name('dashboard');
    });
});
