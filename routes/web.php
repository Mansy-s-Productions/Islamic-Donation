<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HadithController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuranController;
use App\Http\Controllers\SuraListController;
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
Route::prefix('quran')->group(function () {
    Route::get('/', [QuranController::class, 'getAllQuran'])->name('quranList');
    Route::get('/{lang}/sura/{id}', [QuranController::class, 'singleSura'])->name('singleSura');
});
Route::prefix('hadith/{lang?}')->group(function () {
    Route::get('/', [HadithController::class, 'getAllHadith'])->name('hadithList');
    // Route::get('/{lang}/sura/{id}', [HadithController::class, 'singleSura'])->name('singleSura');
});

//Auth System Routes
Route::middleware('guest')->group(function () {
    //Social Signup System
    Route::get('social-login/{provider}', [UserController::class , 'redirectToProvider'])->name('login.social');
    Route::get('login/{driver}/callback', [UserController::class , 'handleProviderCallback'])->name('login.social.callback');
});
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('logout', [AdminController::class, 'logout'])->name('logout');
});
Route::middleware('auth', 'verified', 'admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/users-list', [AdminController::class, 'usersList'])->name('usersList');
    Route::get('/user/{id}', [AdminController::class, 'userEdit'])->name('userEdit');
    Route::post('/user/{id}', [AdminController::class, 'postUserEdit'])->name('userEdit.post');
    Route::prefix('quran-list/{lang?}')->group(function () {
        Route::get('/', [QuranController::class, 'getAdminAll'])->name('admin.quran.all');
        Route::get('sura-edit/{id}', [QuranController::class, 'getEditSura'])->name('admin.sura.getEdit');
        Route::get('aya/{id}', [QuranController::class, 'getEditAya'])->name('admin.aya.getEdit');
        Route::post('aya/{id}', [QuranController::class, 'postEditAya'])->name('admin.aya.postEdit');
    });
    Route::prefix('hadith-list/{lang?}')->group(function () {
        Route::get('/', [HadithController::class, 'getAdminAll'])->name('admin.hadith.all');
        Route::get('hadith/{id}', [HadithController::class, 'getEditHadith'])->name('admin.hadith.getEdit');
        Route::post('hadith/{id}', [HadithController::class, 'postEditHadith'])->name('admin.hadith.postEdit');
    });
    Route::prefix('languages')->group(function(){
        Route::get('/', [LanguageController::class , 'getAdminLanguages'])->name('admin.languages.all');
        Route::get('new', [LanguageController::class , 'getCreateLanguage'])->name('admin.languages.getCreate');
        Route::post('new', [LanguageController::class , 'postCreateLanguage'])->name('admin.languages.postCreate');
        Route::get('edit/{id}', [LanguageController::class , 'getEditLanguage'])->name('admin.languages.getEdit');
        Route::post('edit/{id}', [LanguageController::class , 'postEditLanguage'])->name('admin.languages.postEdit');
        Route::get('delete/{id}', [LanguageController::class , 'deleteLanguage'])->name('admin.languages.delete');
    });

});
require __DIR__.'/auth.php';

