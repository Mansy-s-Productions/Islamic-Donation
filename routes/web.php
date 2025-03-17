<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HadithController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuranController;
use App\Http\Controllers\UserController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('quran', [QuranController::class, 'getAllQuran'])->name('quranList');
Route::get('islamic-links', [QuranController::class, 'getIslamicLinks'])->name('islamicLinks');
Route::get('{lang}/sura/{id}', [QuranController::class, 'singleSura'])->name('singleSura');

Route::prefix('hadith/{lang?}')->group(function () {
    Route::get('categories/list/', [HadithController::class, 'getAllCategories'])->name('categoriesList');
    Route::get('list/category/{id?}', [HadithController::class, 'getAllHadith'])->name('hadithList');
});

// Auth System Routes
Route::middleware('guest')->group(function () {
    // Social Signup System
    Route::get('social-login/{provider}', [UserController::class, 'redirectToProvider'])->name('login.social');
    Route::get('login/{driver}/callback', [UserController::class, 'handleProviderCallback'])->name('login.social.callback');
});
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('logout', [AdminController::class, 'logout'])->name('logout');
});
Route::middleware('auth', 'verified', 'admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::prefix('dashboard')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('dashboard');
        Route::get('/users-list', [AdminController::class, 'usersList'])->name('usersList');
        Route::prefix('user')->group(function () {
            Route::get('edit/{id}', [AdminController::class, 'userEdit'])->name('userEdit');
            Route::post('edit/{id}', [AdminController::class, 'postUserEdit'])->name('userEdit.post');
            Route::get('report/{id}', [AdminController::class, 'getUserReport'])->name('userReport.get');
        });
        Route::prefix('quran')->group(function () {
            Route::get('{lang}', [QuranController::class, 'getAdminAll'])->name('admin.quran.all');
            Route::get('sura/{lang}/{id}/', [QuranController::class, 'getEditSura'])->name('admin.sura.getEdit');
            Route::get('aya/{lang}/{suraId}/{ayaId}', [QuranController::class, 'getEditAya'])->name('admin.aya.getEdit');
            Route::post('aya/{lang}/{suraId}/{ayaId}', [QuranController::class, 'postEditAya'])->name('admin.aya.postEdit');
        });
        Route::prefix('hadith')->group(function () {
            Route::get('all/{category_id}/{lang}', [HadithController::class, 'getAdminAll'])->name('admin.hadith.all');
            Route::get('edit/{id}/{lang?}', [HadithController::class, 'getEditHadith'])->name('admin.hadith.getEdit');
            Route::post('edit/{id}/{lang?}', [HadithController::class, 'postEditHadith'])->name('admin.hadith.postEdit');
        });
    });

});
require __DIR__.'/auth.php';
