<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubmenuController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\GuestArticleController;

// public route
Route::get('/', [HomeController::class, 'index']);
Route::get('/artikel', [ArticleController::class, 'publicIndex'])->name('public.article.index');
Route::get('/artikel/kategori/{category:slug}', [ArticleController::class, 'publicIndex'])->name('public.article.category');
Route::get('/artikel/author/{author}', [ArticleController::class, 'publicIndex'])->name('public.article.author');
Route::get('/artikel/{article:slug}', [ArticleController::class, 'show'])->name('public.article.show');

Route::get('/berita', [NewsController::class, 'publicIndex'])->name('public.news.index');
Route::get('/berita/{news:slug}', [NewsController::class, 'show'])->name('news.show');

Route::get('/pengumuman', [AnnouncementController::class, 'publicIndex'])->name('public.announcement.index');
Route::get('/pengumuman/{announcement:slug}', [AnnouncementController::class, 'show'])->name('announcement.show');

Route::get('/page/{page:slug}', [PageController::class, 'show'])->name('page.show');
Route::get('/slider/{slider:slug}', [SliderController::class, 'show'])->name('public.slider.show');

// feedback
Route::post('/feedback', [\App\Http\Controllers\FeedbackController::class, 'store'])
    ->middleware('throttle:5,60')
    ->name('feedback.store');

// guest article submission
Route::get('/ajukan-artikel', [GuestArticleController::class, 'create'])->name('public.article.create');

Route::middleware(['throttle:5,60'])->group(function () {
    Route::post('/ajukan-artikel', [GuestArticleController::class, 'store'])->name('public.article.store');
    Route::post('/guest/article/upload-image', [GuestArticleController::class, 'uploadImage'])->name('public.article.uploadImage');
    Route::post('/guest/article/delete-image', [GuestArticleController::class, 'deleteImage'])->name('public.article.deleteImage');
});

// auth route
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// protected route
Route::middleware(['auth'])->group(function () {
    // shared routes for admin and upt
    Route::middleware(['role:admin,upt'])->prefix('dashboard')->group(function () {
        // article
        Route::resource('article', ArticleController::class)->names('admin.article');
        Route::post('article/{article}/toggle-status', [ArticleController::class, 'toggleStatus'])->name('admin.article.toggleStatus');
        Route::post('article/upload-image', [ArticleController::class, 'uploadImage'])->name('admin.article.uploadImage');
        Route::post('article/delete-image', [ArticleController::class, 'deleteImage'])->name('admin.article.deleteImage');

        // news
        Route::resource('news', NewsController::class)->except(['show'])->names('admin.news');
        Route::post('news/{news}/toggle-status', [NewsController::class, 'toggleStatus'])->name('admin.news.toggleStatus');
        Route::post('news/upload-image', [NewsController::class, 'uploadImage'])->name('admin.news.uploadImage');
        Route::post('news/delete-image', [NewsController::class, 'deleteImage'])->name('admin.news.deleteImage');
        Route::post('news/upload-video', [NewsController::class, 'uploadVideo'])->name('admin.news.uploadVideo');

        // profile
        Route::get('profile', [ProfileController::class, 'edit'])->name('admin.profile.edit');
        Route::put('profile', [ProfileController::class, 'update'])->name('admin.profile.update');

        // account settings
        Route::get('account', [ProfileController::class, 'editAccount'])->name('admin.account.edit');
        Route::put('account', [ProfileController::class, 'updateAccount'])->name('admin.account.update');

        // announcement
        Route::resource('announcement', AnnouncementController::class)->except(['show'])->names('admin.announcement');
        Route::post('announcement/upload-image', [AnnouncementController::class, 'uploadImage'])->name('admin.announcement.uploadImage');
        Route::post('announcement/delete-image', [AnnouncementController::class, 'deleteImage'])->name('admin.announcement.deleteImage');
    });

    // admin only route
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        // dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // menu
        Route::resource('menu', MenuController::class)->names('menu');

        // submenu
        Route::resource('submenu', SubmenuController::class)->names('submenu');

        // slider
        Route::resource('slider', SliderController::class)->names('slider');

        // user
        Route::resource('user', UserController::class)->names('user');

        // article submissions
        Route::get('article/submissions', [ArticleController::class, 'submissions'])->name('article.submissions');
        Route::post('article/{article}/approve', [ArticleController::class, 'approve'])->name('article.approve');
        Route::post('article/{article}/reject', [ArticleController::class, 'reject'])->name('article.reject');

        // page
        Route::resource('page', PageController::class)->except(['show'])->names('page');
        Route::post('page/upload-image', [PageController::class, 'uploadImage'])->name('page.uploadImage');
        Route::post('page/delete-image', [PageController::class, 'deleteImage'])->name('page.deleteImage');

        // category
        Route::resource('category', CategoryController::class)->names('category');

        // feedback
        Route::resource('feedback', \App\Http\Controllers\FeedbackController::class)->only(['index', 'show', 'destroy'])->names('feedback');
    });

    // upt only route
    Route::middleware(['role:upt'])->prefix('upt')->name('upt.')->group(function () {
        // dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    });
});
