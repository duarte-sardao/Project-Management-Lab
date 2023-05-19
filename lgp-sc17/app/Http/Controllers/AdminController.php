<?php

namespace App\Http\Controllers;

use App\Models\LibraryPost;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminController extends Controller
{
    function index() {
        return Inertia::render('Admin/Dashboard', [
            'users' => [],
            'library_posts' => LibraryPost::orderBy('created_at', 'desc')->limit(4)->get(),
            'forum_posts' => []
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

    function forumIndex() {
        return Inertia::render('Admin/Forum/Forum');
    }
}
