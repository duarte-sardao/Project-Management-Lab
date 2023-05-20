<?php

namespace App\Http\Controllers;

use App\Models\ForumPost;
use App\Models\Topic;
use App\Models\LibraryPost;

use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminController extends Controller
{
    function index() {
        return Inertia::render('Admin/Dashboard');
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
        $forum_posts = ForumPost::all();
        $posts = collect([]);
        foreach ($forum_posts as $forum_post) {
            $posts->push([
                "id" => $forum_post->id,
                "title" => $forum_post->title,
                "date" => $forum_post->post->posted_at->format('d/m/Y'),
            ]);
        }

        $result = [
            'topics' => Topic::select('id', 'topic', 'color')->get(),
            'posts' => $posts,  
        ];

        $message = $request->session()->get('success');
        if (!is_null($message)) $result['message'] = $message;

        return Inertia::render('Admin/Forum/Forum', $result);
    }
}
