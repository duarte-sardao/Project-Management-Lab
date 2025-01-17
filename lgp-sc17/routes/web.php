<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\HospitalController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\ChatsController;
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

Route::middleware(['auth', 'bancheck'])->group(function () {
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
    Route::delete('/forum/{id}', [ForumController::class, 'deletePost'])->name('forum.post.delete');
    Route::delete('/forum/answer/{id}', [ForumController::class, 'deleteAnswer'])->name('forum.answer.delete');
    Route::post('/forum/{id}', [ForumController::class, 'answer'])->name('forum.answer');

    Route::post('/topic/{id}', [TopicController::class, 'follow'])->name('topic.follow');
    Route::delete('/topic/{id}', [TopicController::class, 'delete'])->name('topic.delete');
    Route::get('/newTopic', [TopicController::class, 'create'])->name('topic.new');
    Route::post('/newTopic', [TopicController::class, 'store'])->name('topic.create');
    Route::get('/topic/{id}', [TopicController::class, 'edit'])->name('topic.edit');
    Route::put('/topic/{id}', [TopicController::class, 'update'])->name('topic.update');

    Route::get('/profile', [ProfileController::class, 'visualize'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/chat', [ChatsController::class, 'index'])->name('chat');
    Route::get('/messages', [ChatsController::class, 'fetchMessagesPatient']);
    Route::post('/messages', [ChatsController::class, 'sendMessagePatient']);
    Route::get('/messagesMedic', [ChatsController::class, 'fetchMessagesMedic']);
    Route::post('/messagesMedic', [ChatsController::class, 'sendMessageMedic']);

    Route::get('/getMedics', [ChatsController::class, 'fetchMedics']);
    Route::get('/getPatients', [ChatsController::class, 'fetchPatients']);

    Route::middleware('admin')->group(function () {
        //Dashboard
        Route::get('/admin', [AdminController::class, 'index'])->name('admin');

        //Users
        Route::get('/admin/users', [AdminController::class, 'usersIndex'])->name('admin.users');
        Route::get('/api/admin/users', [ApiController::class, 'userListAdmin']);
        Route::get('/admin/users/{id}', [AdminController::class, 'userInfo'])->name('admin.users.info');
        Route::post('/admin/users/setAdmin/{id}', [AdminController::class, 'setAdmin'])->name('admin.users.setAdmin');
        Route::post('/admin/users/unsetAdmin/{id}', [AdminController::class, 'unsetAdmin'])->name('admin.users.unsetAdmin');
        Route::post('/admin/users/ban/{id}', [AdminController::class, 'ban'])->name('admin.users.ban');
        Route::post('/admin/users/unban/{id}', [AdminController::class, 'unban'])->name('admin.users.unban');
        Route::post('/admin/users/registerMedic/{id}', [AdminController::class, 'registerMedic'])->name('admin.users.registerMedic');
        Route::post('/admin/users/registerPatient/{id}', [AdminController::class, 'registerPatient'])->name('admin.users.registerPatient');
        Route::post('/admin/users/patient/{id}', [AdminController::class, 'setPatientQuestionnaire'])->name('admin.users.patient.questionnaire');
        Route::post('/admin/users/setDate/{id}', [AdminController::class, 'setDate'])->name('admin.users.setDate');
        Route::post('/admin/users/{id}', [RegisteredMedicController::class, 'storeFromUser'])->name('admin.register.medic');
        Route::post('/admin/users/{id}', [RegisteredPatientController::class, 'storeFromUser'])->name('admin.register.patient');

        //Library
        Route::get('/admin/library', [AdminController::class, 'libraryIndex'])->name('admin.library');
        Route::get('/api/admin/library', [ApiController::class, 'libraryPostsAdmin']);
        Route::get('/admin/library/new', [AdminController::class, 'libraryNew'])->name('admin.library.create');
        Route::post('/admin/library/new', [LibraryController::class, 'create'])->name('admin.library.new');
        Route::get('/admin/library/{id}', [AdminController::class, 'libraryPost'])->name('admin.library.post');
        Route::post('/admin/library/{id}', [LibraryController::class, 'edit'])->name('admin.library.edit');
        Route::delete('/admin/library/{id}', [LibraryController::class, 'delete'])->name('admin.library.delete');

        //Forum
        Route::get('/admin/forum', [AdminController::class, 'forumIndex'])->name('admin.forum');
        Route::get('/api/admin/forum', [ApiController::class, 'forumPostsAdmin'])->name('admin.forum.search');

        //Hospitals
        Route::get('/admin/hospitals', [AdminController::class, 'hospitalsIndex'])->name('admin.hospitals');
        Route::get('/api/admin/hospitals', [ApiController::class, 'hospitals']);
        Route::post('/admin/hospitals/new', [HospitalController::class, 'create'])->name('admin.hospitals.create');
        Route::delete('/admin/hospitals/{id}', [HospitalController::class, 'delete'])->name('admin.hospitals.delete');

        //Chat
        Route::get('/admin/chat', [AdminController::class, 'chatIndex'])->name('admin.chat');
        Route::get('/admin/chat/{patient_id}/medics', [ChatController::class, 'chatMedics'])->name('admin.chat.medics');
        Route::get('/api/admin/chat/patients', [ApiController::class, 'chatPatients']);
        Route::get('/api/admin/chat/medics', [ApiController::class, 'chatMedics']);
        Route::post('/admin/chat/{patient_id}/medics/{medic_id}', [ChatController::class, 'addMedicToPatient'])->name('admin.chat.medics.associate');
        Route::delete('/admin/chat/{patient_id}/medics/{medic_id}', [ChatController::class, 'removeMedicToPatient'])->name('admin.chat.medics.remove');
    });
});

Route::post('about-form', [MailController::class, 'sendEmail'])->name('about-form');

require __DIR__.'/auth.php';
