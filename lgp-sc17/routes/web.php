<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MailController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/library', function () {
    return Inertia::render('Library/Library');
})->name('library');

Route::get('/library/{id}', function () {
    return Inertia::render('Library/LibraryPost');
})->name('libraryPost');

Route::get('/about', function () {
    return Inertia::render('About');
})->name('about');

Route::get('/Terms&Conditions', function () {
    return Inertia::render('About');
})->name('Terms&Conditions');

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

        //Library
        Route::get('/admin/library', [AdminController::class, 'libraryIndex'])->name('admin.library');
        Route::get('/admin/library/new', [AdminController::class, 'libraryIndex'])->name('admin.library.new');

        //Forum
        Route::get('/admin/forum', [AdminController::class, 'forumIndex'])->name('admin.forum');
    });
});

Route::post('about-form', [MailController::class, 'sendEmail'])->name('about-form');

require __DIR__.'/auth.php';
