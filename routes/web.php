<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubmenuController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\GuestArticleController;

// public route
Route::get('/', [HomeController::class, 'index']);
Route::get('/artikel/{article:slug}', [App\Http\Controllers\ArticleController::class, 'show'])->name('public.article.show');
Route::get('/berita/{news:slug}', [NewsController::class, 'show'])->name('news.show');
Route::get('/pengumuman/{announcement:slug}', [AnnouncementController::class, 'show'])->name('announcement.show');
Route::get('/page/{page:slug}', [PageController::class, 'show'])->name('page.show');

// guest article submission
Route::middleware(['throttle:3,60'])->group(function () {
    Route::get('/ajukan-artikel', [GuestArticleController::class, 'create'])->name('public.article.create');
    Route::post('/ajukan-artikel', [GuestArticleController::class, 'store'])->name('public.article.store');
    Route::post('/guest/article/upload-image', [GuestArticleController::class, 'uploadImage'])->name('public.article.uploadImage');
});

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
        Route::get('article/submissions', [App\Http\Controllers\ArticleController::class, 'submissions'])->name('article.submissions');
        Route::post('article/{article}/approve', [App\Http\Controllers\ArticleController::class, 'approve'])->name('article.approve');
        Route::post('article/{article}/reject', [App\Http\Controllers\ArticleController::class, 'reject'])->name('article.reject');
        Route::resource('article', App\Http\Controllers\ArticleController::class)->names('article');
        Route::post('article/upload-image', [App\Http\Controllers\ArticleController::class, 'uploadImage'])->name('article.uploadImage');

        // news
        Route::resource('news', NewsController::class)->except(['show'])->names('news');
        Route::post('news/upload-image', [NewsController::class, 'uploadImage'])->name('news.uploadImage');
        Route::post('news/upload-video', [NewsController::class, 'uploadVideo'])->name('news.uploadVideo');

        // announcement
        Route::resource('announcement', AnnouncementController::class)->except(['show'])->names('announcement');
        Route::post('announcement/upload-image', [AnnouncementController::class, 'uploadImage'])->name('announcement.uploadImage');

        // page
        Route::resource('page', PageController::class)->except(['show'])->names('page');
        Route::post('page/upload-image', [PageController::class, 'uploadImage'])->name('page.uploadImage');

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
