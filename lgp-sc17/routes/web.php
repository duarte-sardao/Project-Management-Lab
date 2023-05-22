<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MailController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use UniSharp\LaravelFilemanager\Lfm;
use App\Http\Controllers\Auth\RegisteredPatientController;
use App\Http\Controllers\Auth\RegisteredMedicController;

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

Route::get('/', function () {
    return Inertia::render('Home');
})->name('homepage');

Route::get('/library', [LibraryController::class, 'index'])->name('library');
Route::get('/api/library', [ApiController::class, 'libraryPosts']);

Route::get('/library/{id}', [LibraryController::class, 'post'])->name('libraryPost');

Route::get('/about', function () {
    return Inertia::render('About');
})->name('about');

Route::get('/Terms&Conditions', function () {
    return Inertia::render('About');
})->name('Terms&Conditions');

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    Lfm::routes();
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'visualize'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('admin')->group(function () {
        //Dashboard
        Route::get('/admin', [AdminController::class, 'index'])->name('admin');

        //Users
        Route::get('/admin/users', [AdminController::class, 'usersIndex'])->name('admin.users');
        Route::get('/api/admin/users', [ApiController::class, 'userListAdmin']);
        Route::get('/admin/users/{id}', [AdminController::class, 'userInfo'])->name('admin.users.info');
        Route::post('/admin/users/{id}', [RegisteredMedicController::class, 'storeFromUser'])->name('admin.register.medic');
        Route::post('/admin/users/{id}', [RegisteredPatientController::class, 'storeFromUser'])->name('admin.register.patient');
        //keeps missing the admin.register.medic and patient routes idk
        //Library
        Route::get('/admin/library', [AdminController::class, 'libraryIndex'])->name('admin.library');
        Route::get('/api/admin/library', [ApiController::class, 'libraryPostsAdmin']);
        Route::get('/admin/library/new', [AdminController::class, 'libraryNew'])->name('admin.library.new');
        Route::post('/admin/library/new', [LibraryController::class, 'create'])->name('admin.library.new');
        Route::get('/admin/library/{id}', [AdminController::class, 'libraryPost'])->name('admin.library.post');
        Route::post('/admin/library/{id}', [LibraryController::class, 'edit'])->name('admin.library.post');
        Route::delete('/admin/library/{id}', [LibraryController::class, 'delete'])->name('admin.library.post');


        //Forum
        Route::get('/admin/forum', [AdminController::class, 'forumIndex'])->name('admin.forum');
    });
});

Route::post('about-form', [MailController::class, 'sendEmail'])->name('about-form');

require __DIR__.'/auth.php';
