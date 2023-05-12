<?php

namespace App\Http\Controllers;

use App\Models\LibraryPost;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminController extends Controller
{
    function index() {
        return Inertia::render('Admin/Dashboard');
    }

    function usersIndex() {
        return Inertia::render('Admin/Users');
    }

    function libraryIndex() {
        return Inertia::render('Admin/Library');
    }

    function libraryNew() {
        return Inertia::render('Admin/LibraryNewPost');
    }

    function libraryPost($id) {
        $post = LibraryPost::find($id);
        return Inertia::render('Admin/LibraryPost', [
            'id' => $post->id,
            'title' => $post->title,
            'subtitle' => $post->subtitle,
            'content' => $post->content,
            'public' => $post->public,
        ]);
    }

    function forumIndex() {
        return Inertia::render('Admin/Forum');
    }
}
