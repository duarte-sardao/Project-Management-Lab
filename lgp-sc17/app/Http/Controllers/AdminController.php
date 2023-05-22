<?php

namespace App\Http\Controllers;

use App\Models\ForumPost;
use App\Models\Topic;
use App\Models\LibraryPost;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminController extends Controller
{
    function index() {
        return Inertia::render('Admin/Dashboard', [
            'users' => [],
            'library_posts' => LibraryPost::orderBy('created_at', 'desc')->limit(4)->get(),
            'forum_posts' => ForumPost::join('posts', 'post_id', '=', 'posts.id')
                ->orderBy('posted_at', 'desc')
                ->select('forum_posts.id', 'title', DB::raw("DATE_FORMAT(posted_at, '%d/%m/%Y') as date"))
                ->limit(4)->get()
        ]);
    }

    function usersIndex() {
        return Inertia::render('Admin/Users/Users');
    }

    function libraryIndex() {
        return Inertia::render('Admin/Library/Library', [
            'posts' => LibraryPost::orderBy('created_at', 'desc')->paginate(6)
        ]);
    }

    function libraryNew() {
        return Inertia::render('Admin/Library/LibraryNewPost');
    }

    function libraryPost($id) {
        return Inertia::render('Admin/Library/LibraryPost', [
            'post' => LibraryPost::find($id)
        ]);
    }

    function forumIndex(Request $request) {
        $result = [
            'topics' => Topic::select('id', 'topic', 'color')->get(),
            'posts' => ForumPost::join('posts', 'post_id', '=', 'posts.id')
                ->orderBy('posted_at', 'desc')
                ->select('forum_posts.id', 'title', DB::raw("DATE_FORMAT(posted_at, '%d/%m/%Y') as date"))
                ->paginate(6),
            ];

        $message = $request->session()->get('success');
        if (!is_null($message)) $result['message'] = $message;

        return Inertia::render('Admin/Forum/Forum', $result);
    }
}
