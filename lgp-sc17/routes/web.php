<?php

use App\Http\Controllers\ForumController;
use App\Http\Controllers\ProfileController;
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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('homepage');

Route::get('/library', function () {
    return Inertia::render('Library');
})->name('library');

Route::get('/about', function () {
    return Inertia::render('About');
})->name('about');

Route::get('/Terms&Conditions', function () {
    return Inertia::render('About');
})->name('Terms&Conditions');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('forum/search', [ForumController::class, 'search'])->name('forum.search');
    Route::get('/forum', [ForumController::class, 'posts'])->name('forum');
    Route::get('/forum/my_discussions', [ForumController::class, 'my_discussions'])->name('forum-my_discussions');
    Route::get('/forum/following', [ForumController::class, 'following_posts'])->name('forum-following');
    Route::get('/forum/topic/{id}/posts', [ForumController::class, 'topic_posts'])->name('forum-topic_posts');
    Route::get('/forum/search/{query}', [ForumController::class, 'search'])->name('forum-search');
    Route::get('/forum/new', [ForumController::class, 'create'])->name('forum.new');
    Route::post('forum/new', [ForumController::class, 'store'])->name('forum.create');
    Route::post('forum/{id}/like', [ForumController::class, 'like'])->name('forum.like-post');
    Route::post('forum/answer/{id}/like', [ForumController::class, 'likeAnswer'])->name('forum.like-answer');
    Route::post('forum/topic/{id}/follow', [ForumController::class, 'follow'])->name('forum.follow');
    Route::get('/forum/{id}', [ForumController::class, 'post'])->name('forum.post');
    Route::post('/forum/{id}', [ForumController::class, 'answer'])->name('forum.answer');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
