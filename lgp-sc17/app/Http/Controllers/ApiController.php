<?php

namespace App\Http\Controllers;

use App\Models\LibraryPost;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    function libraryPosts() {
        return LibraryPost::where('public','=',true)->orderBy('created_at', 'desc')->paginate(8);
    }

    function libraryPostsAdmin() {
        return LibraryPost::orderBy('created_at', 'desc')->paginate(6);
    }
}
