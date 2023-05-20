<?php

use App\Http\Controllers\ForumController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MailController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use UniSharp\LaravelFilemanager\Lfm;

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

Route::get('/', [HomepageController::class, 'index'])->name('homepage');

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
    Route::get('/forum/{id}', [ForumController::class, 'post'])->name('forum.post');
    Route::delete('/forum/{id}', [ForumController::class, 'destroyPost'])->name('forum.post.destroy');
    Route::delete('/forum/answer/{id}', [ForumController::class, 'destroyAnswer'])->name('forum.answer.destroy');
    Route::post('/forum/{id}', [ForumController::class, 'answer'])->name('forum.answer');

    Route::post('/topic/{id}', [TopicController::class, 'follow'])->name('topic.follow');
    Route::delete('/topic/{id}', [TopicController::class, 'destroy'])->name('topic.destroy');
    Route::get('/newTopic', [TopicController::class, 'create'])->name('topic.new');
    Route::post('/newTopic', [TopicController::class, 'store'])->name('topic.create');

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
        Route::get('/api/admin/library', [ApiController::class, 'libraryPostsAdmin']);
        Route::get('/admin/library/new', [AdminController::class, 'libraryNew'])->name('admin.library.new');
        Route::post('/admin/library/new', [LibraryController::class, 'create'])->name('admin.library.new');
        Route::get('/admin/library/{id}', [AdminController::class, 'libraryPost'])->name('admin.library.post');
        Route::post('/admin/library/{id}', [LibraryController::class, 'edit'])->name('admin.library.post');
        Route::delete('/admin/library/{id}', [LibraryController::class, 'delete'])->name('admin.library.post');


        //Forum
        Route::get('/admin/forum', [AdminController::class, 'forumIndex'])->name('admin.forum');
        Route::get('/api/admin/forum', [ApiController::class, 'forumPostsAdmin'])->name('admin.forum.search');
    });
});

Route::post('about-form', [MailController::class, 'sendEmail'])->name('about-form');

require __DIR__.'/auth.php';
